// Scripts especificos do layout
/**
 * Exemplo:
 * Se precisar adicionar alguma classe ou manipular algum elemento
 *
 *
 */

/* 
Exemplo de um intersection observer
const exampleObserver = new IntersectionObserver(
	(entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				observer.unobserve(entry.target);
                // Executar código aqui
			}
		});
	},
	{
		rootMargin: "0px 0px 0px 0px",
	}
);
exampleObserver.observe(document.querySelector(".teste"));
*/


// Lazy loading das imagens que possuem data-src
(function () {
    var lazyLoadImages = document.querySelectorAll("img[data-src]");
    if (lazyLoadImages) {
        const lazyLoadObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        let currentImage = entry.target;
                        currentImage.src = currentImage.dataset.src; // src = data-src
                        // Remove loader caso ele seja o proximo irmao daquela imagem
                        entry.target.addEventListener("load", function () {
                            let loader = this.nextElementSibling;
                            if (loader && loader.classList.contains("loader"))
                                loader.remove();
                        });
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                rootMargin: "50% 50% 50% 50%",
            }
        );

        lazyLoadImages.forEach((el) => {
            lazyLoadObserver.observe(el);
        });
    }
})();

// Botão whatsapp fixo
$(document).ready(function () {
    $(".btn-whatsapp").click(function () {
        $(this).addClass("active");
        $(".whatsapp-form").toggleClass("show");
    });

    $(".whatsapp-form-close").click(function () {
        $(".whatsapp-form").removeClass("show");
        $(".btn-whatsapp").removeClass("active");
    });

    $(".timeline-image").css({
        "margin-top": -$(".timeline-title").height(),
    });
});

$(document).on("ready resize load", function () {
    $(".timeline-image").css({
        "margin-top": -$(".timeline-title").height(),
    });
});

window.addEventListener('fadeflash', event => {
    setTimeout(function () {
        var successAlerts = document.querySelectorAll('.alert.alert-success:not(.animating)');
        successAlerts.forEach(function (alert) {
            fadeOut(alert);
        });
    }, 1000);
});

function fadeOut(element) {
    var opacity = 1;
    var timer = setInterval(function () {
        if (opacity <= 0.1) {
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = opacity;
        opacity -= opacity * 0.1;
    }, 15);

    // Add class to indicate that element is animating
    element.classList.add('animating');

    // Remove class when animation completes
    setTimeout(function () {
        element.classList.remove('animating');
    }, 1500); // Adjust timing to match your animation duration
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                let offset = 0;

                if (window.innerWidth <= 768) {
                    offset = 0;
                }

                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;

                window.scrollTo({
                    top: targetPosition + offset,
                    behavior: 'smooth'
                });

            }
        });
    });
});