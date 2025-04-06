(function () {
    "use strict";

    window.onload = function () {

        // Preloader JS
        const getPreloaderId = document.getElementById('preloader');
        if (getPreloaderId) {
            getPreloaderId.style.display = 'none';
        }

        // Header Sticky
        const getHeaderId = document.getElementById("header-area");
        if (getHeaderId) {
            window.addEventListener('scroll', event => {
                const height = 150;
                if(event.target.scrollingElement){
                    const {
                        scrollTop
                    } = event.target.scrollingElement;
                    document.querySelector('#header-area').classList.toggle('sticky', scrollTop >= height);
                }
            });
        }

        // Show Error Message
        try {
            if (message) {
                Swal.fire(message.title, message.description, message.type);
            }
        } catch (err) {}


        //const getHeaderId = document.getElementById("header-area");
    };

    // Menu JS
    let menu, animate;

    (function () {
        // Initialize menu
        let layoutMenuEl = document.querySelectorAll('#layout-menu');
        layoutMenuEl.forEach(function (element) {
            menu = new Menu(element, {
                orientation: 'vertical',
                closeChildren: false
            });
            // Change parameter to true if you want scroll animation
            window.Helpers.scrollToActive((animate = false));
            window.Helpers.mainMenu = menu;
        });

    })();


    // Feather Icons
    try {
        feather.replace();
    } catch (error) {

    }

    //  Digital Date
    function updateDate() {
        var now = new Date();
        var date = now.getDate();
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var month = monthNames[now.getMonth()];
        var year = now.getFullYear();
        var digitalDate = document.getElementById("digitalDate");
        if (digitalDate) {
            digitalDate.innerHTML = date + " " + month + " " + year;
        }
    }
    setInterval(updateDate, 1000);

    // Header Burger Button
    const getHeaderBurgerMenuId = document.getElementById('header-burger-menu');
    if (getHeaderBurgerMenuId) {
        const switchtoggle = document.querySelector(".header-burger-menu");
        const savedTheme = localStorage.getItem("splash_sidebar");
        if (savedTheme) {
            document.body.setAttribute("sidebar-data-theme", savedTheme);
        }
        switchtoggle.addEventListener("click", function () {
            if (document.body.getAttribute("sidebar-data-theme") === "sidebar-hide") {
                document.body.setAttribute("sidebar-data-theme", "sidebar-show");
                localStorage.setItem("splash_sidebar", "sidebar-show");
            } else {
                document.body.setAttribute("sidebar-data-theme", "sidebar-hide");
                localStorage.setItem("splash_sidebar", "sidebar-hide");
            }
        });
    }

    // Sidebar Burger Button
    const getSidebarBurgerMenuId = document.getElementById('sidebar-burger-menu');
    if (getSidebarBurgerMenuId) {
        const switchtoggle = document.querySelector(".sidebar-burger-menu");
        const savedTheme = localStorage.getItem("splash_sidebar");
        if (savedTheme) {
            document.body.setAttribute("sidebar-data-theme", savedTheme);
        }
        switchtoggle.addEventListener("click", function () {
            if (document.body.getAttribute("sidebar-data-theme") === "sidebar-hide") {
                document.body.setAttribute("sidebar-data-theme", "sidebar-show");
                localStorage.setItem("splash_sidebar", "sidebar-show");
            } else {
                document.body.setAttribute("sidebar-data-theme", "sidebar-hide");
                localStorage.setItem("splash_sidebar", "sidebar-hide");
            }
        });
    }

    // Hover Active Background Color
    try {
        // Remove the "active" class from the current element and add it to the new element when hovered over
        var elements = document.querySelectorAll("[id^='my-element']");
        elements.forEach(function (element) {
            element.addEventListener("mouseover", function () {
                elements.forEach(function (el) {
                    el.classList.remove("active");
                });
                element.classList.add("active");
            });
        });

    } catch (err) {}

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Keydown
    try {
        function execCommand(command) {
            document.execCommand(command, false, null);
            document.getElementById('editor').focus();
        }

        document.getElementById('editor').addEventListener('keydown', function (e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                document.execCommand('insertText', false, '\t');
            }
        });
    } catch (err) {}

    // Clipboard
    try {
        new ClipboardJS('.copy-btn');
    } catch (error) {

    }

    // Popover
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    try {
        // Drag & Drop
        sortable('.js-grid', {
            forcePlaceholderSize: true,
            placeholderClass: 'border'
        });
        sortable('.o-sortable', {
            forcePlaceholderSize: true,
            placeholderClass: 'border'
        });
    } catch (error) {

    }

    // Review Rating
    const ratings = document.querySelectorAll('.rating');
    ratings.forEach(rating => {
        rating.addEventListener('click', () => {
            // reset all ratings to default state
            ratings.forEach(rating => {
                rating.classList.remove('active');
            });

            // add active class to clicked rating and all previous ratings
            rating.classList.add('active');
            let prevRating = rating.previousElementSibling;
            while (prevRating) {
                prevRating.classList.add('active');
                prevRating = prevRating.previousElementSibling;
            }
        });
    });

    // Password JS
    try {
        const passwordInput = document.getElementById("password");
        const passwordToggleIcon = document.querySelector(".password-toggle-icon");

        passwordToggleIcon.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggleIcon.classList.remove("ri-eye-off-line");
                passwordToggleIcon.classList.add("ri-eye-line");
            } else {
                passwordInput.type = "password";
                passwordToggleIcon.classList.remove("ri-eye-line");
                passwordToggleIcon.classList.add("ri-eye-off-line");
            }
        });

    } catch {}

    // Tagss
    document.addEventListener('DOMContentLoaded', function () {
        const tagContainer = document.getElementById('tagContainer');
        const tagInput = document.getElementById('tagInput');
        if (tagInput) {
            tagInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' && tagInput.value.trim() !== '') {
                    createTag(tagInput.value.trim());
                    tagInput.value = '';
                }
            });
        }

        function createTag(tagText) {
            const tag = document.createElement('div');
            tag.classList.add('tag');
            tag.innerHTML = `${tagText} <span class="tag-close">&#10006;</span>`;

            tag.querySelector('.tag-close').addEventListener('click', function () {
                tag.remove();
            });

            tagContainer.appendChild(tag);
        }
    });

    // Input JS
    try {
        var resultEl = document.querySelector(".resultSet"),
            plusMinusWidgets = document.querySelectorAll(".add-to-cart-counter");
        for (var i = 0; i < plusMinusWidgets.length; i++) {
            plusMinusWidgets[i].querySelector(".minusBtn").addEventListener("click", clickHandler);
            plusMinusWidgets[i].querySelector(".plusBtn").addEventListener("click", clickHandler);
            plusMinusWidgets[i].querySelector(".count").addEventListener("change", changeHandler);
        }

        function clickHandler(event) {
            var countEl = event.target.parentNode.querySelector(".count");
            if (event.target.className.match(/\bminusBtn\b/)) {
                countEl.value = Number(countEl.value) - 1;
            } else if (event.target.className.match(/\bplusBtn\b/)) {
                countEl.value = Number(countEl.value) + 1;
            }
            triggerEvent(countEl, "change");
        };

        function changeHandler(event) {
            resultEl.value = 0;
            for (var i = 0; i < plusMinusWidgets.length; i++) {
                resultEl.value = Number(resultEl.value) + Number(plusMinusWidgets[i].querySelector('.count').value);
            }
        };

        function triggerEvent(el, type) {
            if ('createEvent' in document) {
                var e = document.createEvent('HTMLEvents');
                e.initEvent(type, false, true);
                el.dispatchEvent(e);
            } else {
                var e = document.createEventObject();
                e.eventType = type;
                el.fireEvent('on' + e.eventType, e);
            }
        }
    } catch {}

    // From Validation
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
})();

try {
    // function to set a given theme/color-scheme
    function setTheme(themeName) {
        localStorage.setItem('farol_rtl', themeName);
        document.documentElement.className = themeName;
    }
    // function to toggle between light and dark theme
    function toggleTheme() {
        if (localStorage.getItem('farol_rtl') === 'rtl') {
            setTheme('ltr');
        } else {
            setTheme('rtl');
        }
    }

    // Immediately invoked function to set the theme on initial load
    (function () {
        if (localStorage.getItem('farol_rtl') === 'rtl') {
            setTheme('rtl');
            document.getElementById('slider').checked = false;
        } else {
            setTheme('ltr');
            document.getElementById('slider').checked = true;
        }
    })();
} catch {}

function confirmAndDelete(link, action = 'delete') {
	Swal.fire({
		title: "Are you sure?",
		text: "You won to be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		buttonsStyling: false,
		confirmButtonText: "Yes, " + action.toLowerCase() + " it!",
		cancelButtonText: "No, cancel!",
		reverseButtons: true,
		customClass: {
			confirmButton: "mx-1 btn btn-danger",
			cancelButton: "mx-1 btn btn-default"
		}
	}).then(function (result) {
		if (result.value) {
			location.href = link;
		} else if (result.dismiss === "cancel") {
			Swal.fire(
				"Cancelled",
				capitalize(action) + " operation cancelled :)",
				"error"
			);
		}
	});
}

function capitalize(s)
{
    return s && s[0].toUpperCase() + s.slice(1);
}
