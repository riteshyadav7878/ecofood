/*jQuery*/

(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {
        var popup = new $.Popup({
            content: '<div class="popup-1"> <div class="popup-title"> <h3>20% OFF ON FRIDAY</h3> </div> <div class="popup-content"> <p>Aliquam sed pulvinar odio nunc sit amet varius nulla lorem ipsumate amenaip at. sedpulvinar odiosit amet.</p> </div> <div class="popup-button"> <button class="au-btn au-btn-radius au-btn-primary">View ad</button> </div> </div>',
            type: 'html'
        });
        popup.open();

    });

})(jQuery);

