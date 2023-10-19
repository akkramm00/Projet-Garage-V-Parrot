let MenuBtn = document.querySelector("#MenuBtn");
let Navbar = document.querySelector(".navbar");

MenuBtn.onclick = () => {
    MenuBtn.classList.toggle("fa-times");
    Navbar.classList.toggle("active");
   
};

window.onscroll = () => {
    MenuBtn.classList.remove("fa-times");
    Navbar.classList.remove("active");
    ThemeToggle.classList.remove("active");
};

// LOGIN FORM
document.querySelector("#LoginBtn").onclick = () => {
document.querySelector(".loginFormContainer").classList.toggle("active");
};
document.querySelector("#CloseLoginForm").onclick = () =>{
    document.querySelector(".loginFormContainer").classList.remove("active");
};
//homeParalexEffect
//homeParalex

document.querySelector(".home").onmousemove = (e) => {
    document.querySelectorAll(".homeParalexEffect").forEach((el) => {
        let Speed = el.getAttribute("data-speed")
        let X = (window.innerWidth - e.pageX * Speed)/60;
        let Y = (window.innerHeight - e.pageY * Speed)/60;

        el .style.transform =  `translateX(${Y}px) translateY(${X}px)`;
    });
};
document.querySelector(".home").onmouseleave = (e) => {
    document.querySelectorAll(".homeParalexEffect").forEach((el) => {
        el .style.transform =  `translateX(0px) translateY(0px)`;
    });
};

//Swiper JS for Vehicules Slider
var swiper= new Swiper(".VehiculesSlider", {
    grabCursor: true,
    spaceBetween: 20,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // This is For Responsive
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3
        },
    },
});

// Swiper JS FOR featured Slider
var swiper= new Swiper(".featureslider", {
    grabCursor: true,
    spaceBetween: 20,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // This is For Responsive
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3
        },
    },
});
//Theme Toggle
let ThemeToggle = document.querySelector(".themeToggle");
let ToggleBtn = document.querySelector(".ToggleBtn");

ToggleBtn.onclick = () => {
    ThemeToggle.classList.toggle("active");
    Menu.classList.remove("fa-times");
    Navbar.classList.remove("active");
};
document.querySelectorAll(".themeToggle .themeBtn").forEach((btn) => {
    btn.onclick = () => {
        let color = btn.style.background;
        document.querySelector(":root").style.setProperty("--main" ,color);
    };
});

// Swiper JS FOR featured Slider
var swiper= new Swiper(".featureslider", {
    grabCursor: true,
    spaceBetween: 20,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // This is For Responsive
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3
        },
    },
});

// Swiper JS for Review Slider

var swiper= new Swiper(".ReviewSlider", {
    grabCursor: true,
    spaceBetween: 20,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // This is For Responsive
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3
        },
    },
});