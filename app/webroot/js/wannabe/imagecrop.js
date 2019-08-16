$(document).ready(function() {
    $("#profile-crop-image").cropper({
        aspectRatio: 3 / 4,
        preview: "#picture-preview",
        viewMode: 1,
        crop: function(e) {
            $('input[name="x"]').val(e.x);
            $('input[name="y"]').val(e.y);
            $('input[name="width"]').val(e.width);
            $('input[name="height"]').val(e.height);
        }
    });
});