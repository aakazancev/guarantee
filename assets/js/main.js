gsap.registerPlugin(ScrollTrigger);

if (window.matchMedia("(min-width: 1000px)").matches) {
    const content = document.querySelector('.page');

    let headAnim = gsap.timeline({ ease: "power1.out", duration: 0.6 });
    headAnim.from(".header__logo", { opacity: 0, x: -20 })
        .from(".main-menu", { opacity: 0, x: -20 }, "-=0.4")
        .from(".header__contact", { opacity: 0, x: 20 }, "-=0.4")
        .from(".h1-title", { opacity: 0, x: 20 }, "-=0.4")
        .from(".offer__desc", { opacity: 0, x: 20 }, "-=0.4")
        .from(".offer__bullets", { opacity: 0, x: 20 }, "-=0.4")
        .from(".btn-group", { opacity: 0, x: -20 }, "-=0.4")
        .from(".offer__img", { opacity: 0, x: 20 }, "-=0.4")
        .from(".logo-partners", { opacity: 0, y: 20 }, "-=0.4");

    if(content){
        let pageContent = gsap.timeline({ ease: "power1.out", duration: 0.6 });
        pageContent.from(".page", { opacity: 0 });
    }

    let service = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".service",
        }
    });
    service.from(".service .h3-title", { opacity: 0, y: -30 })
        .from(".service__item", { opacity: 0, y: -30, stagger: 0.3 });

    let cta = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".cta",
        }
    });
    cta.from(".cta", { opacity: 0, y: -30, duration: 0.7 });

    let feedback = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".feedback",
        }
    });
    feedback.from(".feedback", { opacity: 0, y: -100, duration: 0.7 });

    let sale = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".sale",
        }
    });
    sale.from(".sale", { opacity: 0, y: -100, duration: 0.7 });

    let stepWork = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".step-work",
        }
    });
    stepWork.from(".step-work", { opacity: 0, y: -100, duration: 0.7 });

    let contact = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".contact",
        }
    });
    contact.from(".contact", { opacity: 0, y: -100, duration: 0.7 });
    let footer = gsap.timeline({
        ease: "power1.out",
        duration: 0.5,
        scrollTrigger: {
        trigger: ".footer",
        }
    });
    footer.from(".footer", { opacity: 0, y: -10, duration: 0.2 });
}

const burger = document.querySelector(".header__burger");
const nav = document.querySelector(".header__mm");
const closeNav = document.querySelector(".header__mm-close");
const body = document.body;

const toggleElements = function () {
  nav.classList.toggle("show");
  body.classList.toggle("overflow");
};

burger.onclick = toggleElements;
closeNav.onclick = toggleElements;

ymaps.ready(function () {
    var myMap = new ymaps.Map('mapper', {
        center: [50.62509826450369, 36.57632626060482],
        zoom: 16
    }, {
        searchControlProvider: 'yandex#search'
    });
    myMap.controls.remove('geolocationControl');
    myMap.controls.remove('searchControl');
    myMap.controls.remove('trafficControl');
    myMap.controls.remove('typeSelector');
    myMap.controls.remove('fullscreenControl');
    myMap.controls.remove('rulerControl');
    myMap.behaviors.disable(['multiTouch']);
    myMap.behaviors.disable(['scrollZoom']);
    myMap.behaviors.enable(['drag']);
    myPlacemark = new ymaps.Placemark([50.62485257292211, 36.57328999999997], {
        hintContent: 'ЧОО "ЗАЩИТА"',
        balloonContent: 'Обеспечение безопасности предприятий различных видов деятельности'
    }, {
        // Опции.
        // Необходимо указать данный тип макета.
        iconLayout: 'default#image',
        iconImageHref: 'https://choo-ohrana.ru/wp-content/uploads/2019/04/pin.png',
        // Размеры метки.
        iconImageSize: [128, 128],
        // Смещение левого верхнего угла иконки относительно
        // её "ножки" (точки привязки).
        iconImageOffset: [-100, -120]
    });
    myMap.geoObjects.add(myPlacemark)
});


