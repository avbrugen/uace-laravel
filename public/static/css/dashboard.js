$(document).ready(function(){
    var sidebar = $('.container-fluid');

    $('.close_sidebar').on('click', function() {
        if(sidebar.hasClass('sidebar-hided')) {
            sidebar.removeClass('sidebar-hided');
            Cookies.set('sidebar', 'show');
        } else {
            sidebar.addClass('sidebar-hided');
            Cookies.set('sidebar', 'hide');
        }
        return false;
    });

});