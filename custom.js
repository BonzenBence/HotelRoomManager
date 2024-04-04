$(document).ready(function() {
    // Apply Bootstrap classes to form elements
    $('input[type="text"], input[type="password"], select, textarea').addClass('form-control');
    $('input[type="submit"], button').addClass('btn btn-primary');

    // Apply Bootstrap classes to sidebar and navigation
    $('#sidebar').addClass('bg-light');
    $('#mainNav').addClass('nav flex-column');
    $('#mainNav li').addClass('nav-item');
    $('#mainNav li a').addClass('nav-link text-dark');
    $('#mainNav li a.active').addClass('active bg-primary text-white');

    // Apply Bootstrap classes to headings
    $('h1, h2, h3, h4, h5, h6').addClass('text-primary');

    $('.table').DataTable(); // This initializes all tables as DataTables.
});
