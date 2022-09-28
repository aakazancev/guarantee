$('a[href^="#"]').click(function(){
	let scrollTo = $(this).attr('href');
    $('html, body').animate({ 
        scrollTop: $(scrollTo).offset().top 
    }, 1000);
    return false;
});