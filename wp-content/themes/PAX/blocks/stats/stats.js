jQuery(document).ready(function($)
{
    var a = 0;
    $(window).scroll(function() 
    {
        var oTop = $('#stats_id').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            var i = 1;
            jQuery( ".stats-item" ).each(function( index ) {
                var num = jQuery(this).find('.odometernew').attr('data-value');

                const od = new Odometer({
                el: document.getElementById("odometer"+i),
                format: "(,ddd).dd",
                duration: 3000,
                theme: "default"
               });
                od.render();

                // Initial Animation
                setTimeout(function () {
                  od.update(num);
                }, 100);
                i++;
            });
            a = 1;
        }

    });
});