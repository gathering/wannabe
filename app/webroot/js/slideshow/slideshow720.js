var currentSlideshow;
var currentSlide;
var slideshowIndex = -1;
var controllerName = "Slideshow";

document.addEventListener('keydown', function (e) {
    handleKeys(e);
}, false);

window.onload = function () {
    startSlideshow();
    setInterval('refreshSlide()', 5000);
    document.body.style.overflow = "hidden";
    document.body.style.padding = "0";
    document.body.style.margin = "0";
}

function handleKeys(e) {
    switch (e.keyCode) {
        case 37:
            prevSlide();
            break;
        case 39:
            nextSlide();
            break;
        case 32:
            nextSlide();
            break;
    }
}

function refreshSlide() {
    var slideshowJson = fetchSlideshowData();
    currentSlideshow = eval(slideshowJson);
}

function startSlideshow() {
    var slideshowJson = fetchSlideshowData();
    currentSlideshow = eval(slideshowJson);
    showSlideshow(currentSlideshow);
}

function fetchSlideshowData() {
    var docurl = document.location.href;
    docurl = docurl.substring(0, docurl.indexOf(controllerName) + controllerName.length) + "/";

    var jsondata = $.ajax({
        url: docurl + 'getSlideShow/',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        async: false
    }).responseText;

    return jsondata;
}

function showSlideshow(show) {
    currentSlideshow = show;
    nextSlide();
}

function prevSlide() {
    decrementCounter();

    var div = document.createElement('div');
    div.id = "divoverlay";
    div.setAttribute("class", "overlay");
    div.zIndex = 10000;

    document.body.appendChild(div);

    removeAllContent();
    switchSlide();

    setTimeout(prevSlide, currentSlide.duration);
}

function nextSlide() {
    incrementCounter();
    $('#divoverlay').remove();
    var div = document.createElement('div');
    div.id = "divoverlay";
    div.setAttribute("class", "overlay");
    div.zIndex = 10000;

    document.body.appendChild(div);

    removeAllContent();
    switchSlide()

    setTimeout(nextSlide, currentSlide.duration);
}

function removeAllContent() {
    if (document.getElementById('iframehallo') != null) {
        document.body.removeChild(document.getElementById('iframehallo'));
    }
    if (document.getElementById('divhallo') != null) {
        document.body.removeChild(document.getElementById('divhallo'));
    }
    if (document.getElementById('maincontent') != null) {
        document.body.removeChild(document.getElementById('maincontent'));
    }

}

function incrementCounter() {
    if (slideshowIndex == currentSlideshow.length - 1) {
        slideshowIndex = 0;
    }
    else {
        slideshowIndex++;
    }
}

function decrementCounter() {
    if (slideshowIndex == 0) {
        slideshowIndex = currentSlideshow.length - 1;
    }
    else {
        slideshowIndex--;
    }
}

function createFullscreenIframe(url) {
    ifrm = document.createElement("IFRAME");
    ifrm.setAttribute("src", url);
    ifrm.setAttribute("class", "ifrm");
    ifrm.id = "iframehallo";
    ifrm.style.width = "1280px";
    ifrm.style.height = "720px";
    ifrm.frameBorder = "0";
    ifrm.scrolling = "no";
    document.body.appendChild(ifrm);
}

function switchSlide() {
    currentSlide = currentSlideshow[slideshowIndex];

    if (currentSlide.url == null || currentSlide.url == 'scheduleslide') {
        if (currentSlide.url == 'scheduleslide') {
            createSchedule(currentSlide);
        }
        else {
            createSlide2011(currentSlide);
        }
        //fadeIn();
        document.body.removeChild(document.getElementById('divoverlay'));
    }
    else {
        createFullscreenIframe(currentSlide.url);
        document.body.removeChild(document.getElementById('divoverlay'));
    }
}

//function fadeIn(){
//    $(document.getElementById("divoverlay")).animate({
//      opacity: '0'
//     },1000,function(){
//    document.body.removeChild(document.getElementById('divoverlay'));

//});
//}

function createFancySlide(slide) {
    var bg = document.createElement("div");
    bg.setAttribute("class", "bg");
    var title = document.createElement("div");
    title.setAttribute("class", "title");
    title.innerHTML = slide.title;
    title.align = "center";
    bg.appendChild(title);

    var content = document.createElement("div");
    content.setAttribute("class", "content");
    content.innerHTML = slide.content;
    content.align = "center";
    bg.appendChild(content);
    if (bg.url != "") {
        bg.style.background = 'url(' + slide.bg_url + ')';
    }
    bg.id = 'divhallo';
    document.body.appendChild(bg);
}

function createSlide2011(slide) {

    var maincontent = document.createElement("div");
    maincontent.id = "maincontent";
    var bottomdiv = document.createElement("div");
    bottomdiv.id = "bottomdiv";
    maincontent.appendChild(bottomdiv);
    var spacer1 = document.createElement("div");
    spacer1.style.height = "20%";
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
}

function createSchedule(slide) {
    var maincontent = document.createElement("div");
    maincontent.id = "maincontent";
    var bottomdiv = document.createElement("div");
    bottomdiv.id = "bottomdiv";
    maincontent.style.textAlign = "left";
    maincontent.style.marginTop = "0px";
    maincontent.style.top = "0px;"
    maincontent.style.position = "asbolute";

    maincontent.appendChild(bottomdiv);

    var spacer1 = document.createElement("div");
    maincontent.appendChild(spacer1);
    var titlecontent = document.createElement("div");
    titlecontent.style.height = "10%";
    titlecontent.id = "titlecontent";
//  titlecontent.style.marginLeft = "100px";
    titlecontent.style.paddingTop = "110px";
    titlecontent.innerHTML = slide.title;
    titlecontent.style.textAlign = "left";
    maincontent.appendChild(titlecontent);
    var spacer2 = document.createElement("div");
    maincontent.appendChild(spacer2);
    var slidecontent = document.createElement("div");
    slidecontent.id = "slidecontent";
    slidecontent.innerHTML = slide.content;
//  slidecontent.style.marginLeft="100px";
    slidecontent.style.textAlign = "left";
    maincontent.appendChild(slidecontent);
    document.body.appendChild(maincontent);
} 

