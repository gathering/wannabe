var Slideshow = (function ($) {

    // Perform self check, display error if missing deps
    var performSelfCheck = function () {
        var errors = false;
        if ($ == undefined) console.error('jQuery missing!');
        if (errors) return false;
        return true
    };

    // Debug method for some formatting and easy switching on/off
    var debug = function (message, method) {
        if (false) {
            if (method != undefined) console.log(method + " - " + message);
            else console.log(message);
        }
    };

    // Allocate private
    var slideshowStarted = false;
    var currentSlideshow = [];
    var currentSlide = false;
    var slideTimeoutID;
    var controllerName = "Slideshow";

    // Original background video which is looping
    var backgroundVideoSrc;

    return {

        init: function () {
            if (!performSelfCheck()) return;

            // Original background video in loop
            backgroundVideoSrc = $("#background-video source").attr("src");

            debug("init", backgroundVideoSrc);

            document.body.style.overflow = "hidden";
            document.body.style.padding = "0";
            document.body.style.margin = "0";

            // Get slides, also starts the slide show after loading slides is done.
            Slideshow.slideshow.refresh();
        },
        /*
        * This object holds slideshow global actions.
         */
        slideshow: {
            start: function () {
                if (!slideshowStarted) {
                    slideshowStarted = true;
                    Slideshow.slide.next();
                }
            },
            refresh: function () {
                var docurl = document.location.href;
                docurl = docurl.substring(0, docurl.indexOf(controllerName) + controllerName.length) + "/";

                $.ajax({
                    url: docurl + 'getSlideShow/',
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: true
                }).done(function (data) {
                    Slideshow.slideshow.update(data);
                    Slideshow.slideshow.start();
                });

                // Run refresh every 5 seconds
                setTimeout(Slideshow.slideshow.refresh, 5000);
                debug("done parsing slideshow", "refresh");
            },
            /*
             * This method takes a data object and compares to current slideshow.
             *
             * It deletes old slides and adds new ones, and preserves a queue while doing so.
             *
             * This method will also trigger creation and removal of stream iframes that need to remain loaded
             * in the background to avoid the buffering at the beginning.
             *
             */
            update: function (newData) {
                debug("Updating..", "update");
                debug("Current slideshow content:", "update");
                debug(currentSlideshow);
                debug("New data from server:", "update");
                debug(newData);

                // Find all the IDs that are supposed to be in the slideshow after update
                var newIDs = [];
                var existingIDs = [];
                $.each(newData, function (i, slide) {
                    newIDs.push(slide.id);
                });

                if (newIDs.length === 0) {
                    debug("No slides in new slideshow, skipping.", "update");
                    return;
                }

                debug("Checking current slides..", "update");

                // Iterate over current slideshow and remove any slides that shouldn't be in it
                $.each(currentSlideshow, function (i, slide) {
                    if ($.inArray(slide.id, newIDs) === -1) {
                        currentSlideshow.splice(i, 1);
                        debug("Removed slike " + slide.id, "update");
                        if (slide.type === "stream") Slideshow.slideshow.removeStreamSlide(slide.id);
                    }
                    else {
                        // Replace this slide with the one from the new data
                        currentSlideshow.splice(i, 1, $.grep(newData, function (e) {
                            return e.id == slide.id;
                        })[0]);
                        debug("Existing slide, adding to existing.", "update");
                        existingIDs.push(slide.id);
                    }
                });

                // Evaluate the current slide
                if (currentSlide) {
                    if ($.inArray(currentSlide.id, newIDs) === -1
                    ) {
                        debug("Current slide was unpublished.", "update");
                        // Delete the slide
                        if (currentSlide.type === "stream") {
                            debug("Scheduling removal of the iframe for stream slide " + currentSlide.id, "update");
                            var deleteID = currentSlide.id;
                            setTimeout(function () {
                                Slideshow.slideshow.removeStreamSlide(deleteID);
                            }, 1500);
                        }
                        currentSlide = false;
                        // Clear the timeout for this slide
                        clearTimeout(slideTimeoutID);
                        // Run next slide in one second
                        setTimeout(Slideshow.slide.next, 1000);
                        // Remove the iframe if it was a stream slide
                    }
                    else {
                        debug("Current slide updated.", "update");
                        currentSlide = $.grep(newData, function (e) {
                            return e.id == currentSlide.id;
                        })[0];
                        existingIDs.push(currentSlide.id);
                    }
                }

                debug("Current slides", "update");
                debug(existingIDs);
                debug("Adding new slides..", "update");

                $.each(newData, function (i, slide) {
                    if ($.inArray(slide.id, existingIDs) === -1) {
                        currentSlideshow.push(slide);
                        debug("Added slide " + i + " " + slide.id);
                        debug(currentSlideshow);
                    }
                });

                debug("Initiating stream slides.", "update");
                Slideshow.slideshow.initStreamSlides();

                debug("Update complete.", "update");
            },
            initStreamSlides: function () {
                for (var i = 0; i < currentSlideshow.length; i++) {
                    var curSlide = currentSlideshow[i];
                    if (curSlide.type === "stream") {
                        if (document.getElementById("iframestream" + curSlide.id) == null) {
                            debug("Found iframe ID " + curSlide.id);
                            Slideshow.slide.create.stream(curSlide);
                            $('video').prop("volume", "0");
                        }
                    }
                }
            },
            removeStreamSlide: function (slideID) {
                $('#iframestream' + slideID).remove();
                debug("Removing stream slide ID " + slideID, "removeStreamSlide");
            }
        },
        /*
        * This object holds methods related to slides.
        * Like cleaning, totating, switching and creating slides.
         */
        slide: {
            next: function () {
                Slideshow.slide.rotate();
                $('#divoverlay').remove();

                var div = document.createElement('div');
                div.id = "divoverlay";
                div.setAttribute("class", "overlay");
                div.zIndex = 10000;
                document.body.appendChild(div);

                Slideshow.slide.clear();
                Slideshow.slide.switch();

                slideTimeoutID = setTimeout(Slideshow.slide.next, currentSlide.duration);
                debug("Showing slide '" + currentSlide.id + "' for '" + currentSlide.duration + "' ms (" + slideTimeoutID + ")", "slide.next");
            },
            previous: function () {
                Slideshow.slide.rotate(true);

                var div = document.createElement('div');
                div.id = "divoverlay";
                div.setAttribute("class", "overlay");
                div.zIndex = 10000;
                document.body.appendChild(div);

                Slideshow.slide.clear();
                Slideshow.slide.switch();

                slideTimeoutID = setTimeout(Slideshow.slide.next, currentSlide.duration);
                debug("Showing slide '" + currentSlide.id + "' for '" + currentSlide.duration + "' ms (" + slideTimeoutID + ")", "slide.previous");
            },
            /*
             * Rotate picks a slide out of the slideshow and holds it until rotation.
             * This only updates the reference to the current slide, nothing else.
             */
            rotate: function (backwards) {
                if (!backwards) {
                    if (currentSlide) currentSlideshow.push(currentSlide);
                    currentSlide = currentSlideshow.shift();
                }
                else {
                    if (currentSlide) currentSlideshow.unshift(currentSlide);
                    currentSlide = currentSlideshow.pop();
                }
            },
            /*
             * Switches the actual view to the new slide, or hides/shows stream slides.
             */
            switch: function () {
                if (currentSlide != null && currentSlide.type != null) {
                    if (currentSlide.type === "stream") {
                        // All slides are premade. We only show them here
                        debug("Disable background animation. (" + backgroundVideoSrc + ")", "slide.switch");
                        $("#background-video").attr("src", "");
                        debug("Moving stream in slide " + currentSlide.id + " to front", "slide.switch");
                        $("#iframestream" + currentSlide.id).css("display", "block");
                    }
                    else {
                        // Check if we need to enable the background again
                        if (backgroundVideoSrc !== $("#background-video").attr("src")) {
                            debug("Enable backgroundanimation. (" + backgroundVideoSrc + ")", "slide.switch");
                            $("#background-video").attr("src", backgroundVideoSrc);
                        }

                        // Hide all iframes. This means stream slides. Other iframes are deleted.
                        $(".ifrm").css("display", "none");

                        // Other slides are created here.
                        if (currentSlide.type === 'text')
                            Slideshow.slide.create.slide(currentSlide);
                        if (currentSlide.type === 'schedule')
                            Slideshow.slide.create.schedule(currentSlide);
                        if (currentSlide.type === 'url')
                            Slideshow.slide.create.fullscreenIframe(currentSlide.url);
                    }
                }
            },
            /*
             * Just remove any content from the slideshow to prepare for next slide.
             */
            clear: function () {
                if (document.getElementById('iframepage') != null) {
                    document.body.removeChild(document.getElementById('iframepage'));
                }
                if (document.getElementById('divhallo') != null) {
                    document.body.removeChild(document.getElementById('divhallo'));
                }
                if (document.getElementById('maincontent') != null) {
                    document.body.removeChild(document.getElementById('maincontent'));
                }
            },
            /*
             * Creates the html for each type of slide.
             */
            create: {
                schedule: function (slide) {
                    var maincontent = document.createElement("div");
                    maincontent.id = "maincontent";
                    maincontent.style.textAlign = "left";
                    maincontent.style.marginTop = "0px";
                    maincontent.style.top = "0px;";
                    maincontent.style.position = "asbolute";
                    var spacer1 = document.createElement("div");
                    maincontent.appendChild(spacer1);
                    var titlecontent = document.createElement("div");
                    titlecontent.style.height = "10%";
                    titlecontent.id = "titlecontent";
                    titlecontent.style.paddingTop = "220px";
                    titlecontent.innerHTML = slide.title;
                    titlecontent.style.textAlign = "left";
                    maincontent.appendChild(titlecontent);
                    var spacer2 = document.createElement("div");
                    spacer2.style.height = "5%";
                    maincontent.appendChild(spacer2);
                    var slidecontent = document.createElement("div");
                    slidecontent.id = "slidecontent";
                    slidecontent.innerHTML = slide.content;
                    slidecontent.style.textAlign = "left";
                    maincontent.appendChild(slidecontent);
                    document.body.appendChild(maincontent);
                },
                slide: function (slide) {
                    var maincontent = document.createElement("div");
                    maincontent.id = "maincontent";
                    var spacer1 = document.createElement("div");
                    spacer1.style.height = "10%";
                    maincontent.appendChild(spacer1);
                    var titlecontent = document.createElement("div");
                    titlecontent.id = "titlecontent";
                    titlecontent.innerHTML = slide.title;
                    maincontent.appendChild(titlecontent);
                    var spacer2 = document.createElement("div");
                    spacer2.style.height = "5%";
                    maincontent.appendChild(spacer2);
                    var slidecontent = document.createElement("div");
                    slidecontent.id = "slidecontent";
                    slidecontent.innerHTML = slide.content;
                    maincontent.appendChild(slidecontent);
                    document.body.appendChild(maincontent);
                },
                fullscreenIframe: function (url) {
                    var ifrm = document.createElement("IFRAME");
                    ifrm.setAttribute("src", url);
                    ifrm.setAttribute("class", "ifrm");
                    ifrm.id = "iframepage";
                    ifrm.style.width = "1920px";
                    ifrm.style.height = "1080px";
                    ifrm.frameBorder = "0";
                    ifrm.scrolling = "no";
                    document.body.appendChild(ifrm);
                },
                stream: function (slide) {
                    console.log("Making stream iframe.");
                    var ifrm = document.createElement("IFRAME");
                    ifrm.setAttribute("src", slide.url);
                    ifrm.setAttribute("class", "ifrm");
                    ifrm.id = "iframestream" + slide.id;
                    ifrm.style.width = "1920px";
                    ifrm.style.height = "1080px";
                    ifrm.style.display = "none";
                    ifrm.frameBorder = "0";
                    ifrm.scrolling = "no";
                    document.body.appendChild(ifrm);
                }
            }
        }

    }

})
(jQuery);

$(document).ready(function () {
    Slideshow.init()
});