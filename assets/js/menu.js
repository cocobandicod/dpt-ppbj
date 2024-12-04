document.addEventListener('DOMContentLoaded', function() {
    const defaultLanguage = "en"; // Default language
    let a = localStorage.getItem("language"); // Get stored language or use default

    function o() {
        n(null === a ? defaultLanguage : a);
        const languages = document.getElementsByClassName("language");
        if (languages) {
            Array.from(languages).forEach(function(langElement) {
                langElement.addEventListener("click", function(e) {
                    n(langElement.getAttribute("data-lang"));
                });
            });
        }
    }

    function n(e) {
        const headerLangImg = document.getElementById("header-lang-img");
        if (headerLangImg) {
            switch (e) {
                case "en": headerLangImg.src = "assets/images/flags/us.svg"; break;
                case "sp": headerLangImg.src = "assets/images/flags/spain.svg"; break;
                case "gr": headerLangImg.src = "assets/images/flags/germany.svg"; break;
                case "it": headerLangImg.src = "assets/images/flags/italy.svg"; break;
                case "ru": headerLangImg.src = "assets/images/flags/russia.svg"; break;
                case "ch": headerLangImg.src = "assets/images/flags/china.svg"; break;
                case "fr": headerLangImg.src = "assets/images/flags/french.svg"; break;
                case "ar": headerLangImg.src = "assets/images/flags/ae.svg"; break;
                default: headerLangImg.src = "assets/images/flags/us.svg"; break;
            }
            localStorage.setItem("language", e);
            a = localStorage.getItem("language");
            if (!a) n(defaultLanguage);
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "assets/lang/" + a + ".json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const translations = JSON.parse(xhr.responseText);
                    Object.keys(translations).forEach(function(key) {
                        const elements = document.querySelectorAll("[data-key='" + key + "']");
                        Array.from(elements).forEach(function(element) {
                            element.textContent = translations[key];
                        });
                    });
                }
            };
            xhr.send();
        }
    }

    function s() {
        const navCollapse = document.querySelectorAll(".navbar-nav .collapse");
        if (navCollapse) {
            Array.from(navCollapse).forEach(function(collapseElement) {
                const collapseInstance = new bootstrap.Collapse(collapseElement, { toggle: false });
                collapseElement.addEventListener("show.bs.collapse", function(e) {
                    e.stopPropagation();
                    const parentCollapse = collapseElement.parentElement.closest(".collapse");
                    if (parentCollapse) {
                        const parentCollapses = parentCollapse.querySelectorAll(".collapse");
                        Array.from(parentCollapses).forEach(function(pc) {
                            const instance = bootstrap.Collapse.getInstance(pc);
                            if (instance !== collapseInstance) instance.hide();
                        });
                    } else {
                        const siblingElements = Array.from(collapseElement.parentElement.children).filter(function(child) {
                            return child !== collapseElement;
                        });
                        siblingElements.forEach(function(sibling) {
                            sibling.classList.remove("show");
                            if (sibling.querySelectorAll("*[id]").length > 2) {
                                const links = sibling.querySelectorAll("ul li a");
                                Array.from(links).forEach(function(link) {
                                    if (link.hasAttribute("aria-expanded")) link.setAttribute("aria-expanded", "false");
                                });
                            }
                        });
                    }
                });
                collapseElement.addEventListener("hide.bs.collapse", function(e) {
                    e.stopPropagation();
                    const childCollapses = collapseElement.querySelectorAll(".collapse");
                    Array.from(childCollapses).forEach(function(cc) {
                        const childCollapseInstance = bootstrap.Collapse.getInstance(cc);
                        childCollapseInstance.hide();
                    });
                });
            });
        }
    }

    function i() {
        const layout = document.documentElement.getAttribute("data-layout");
        let t = sessionStorage.getItem("defaultAttribute");
        t = JSON.parse(t);
        if (t && "twocolumn" === layout && "twocolumn" === t["data-layout"]) {
            if (document.querySelector(".navbar-menu")) {
                document.querySelector(".navbar-menu").innerHTML = d;
            }
            const ulElement = document.createElement("ul");
            ulElement.innerHTML = '<a href="#" class="logo"><img src="assets/images/logo-sm.png" alt="" height="22"></a>';
            Array.from(document.getElementById("navbar-nav").querySelectorAll(".menu-link")).forEach(function(menuLink) {
                ulElement.className = "twocolumn-iconview";
                const liElement = document.createElement("li");
                const clonedLink = menuLink.cloneNode(true);
                clonedLink.querySelectorAll("span").forEach(function(span) {
                    span.classList.add("d-none");
                });
                if (menuLink.parentElement.classList.contains("twocolumn-item-show")) {
                    clonedLink.classList.add("active");
                }
                liElement.appendChild(clonedLink);
                ulElement.appendChild(liElement);
                if (clonedLink.classList.contains("nav-link")) {
                    clonedLink.classList.replace("nav-link", "nav-icon");
                }
                clonedLink.classList.remove("collapsed", "menu-link");
            });

            let currentPath = location.pathname === "/" ? "index.html" : location.pathname.substring(1);
            currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
            if (currentPath) {
                const activeLink = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');
                if (activeLink) {
                    let parentCollapse = activeLink.closest(".collapse.menu-dropdown");
                    if (parentCollapse) {
                        parentCollapse.classList.add("show");
                        parentCollapse.parentElement.children[0].classList.add("active");
                        parentCollapse.parentElement.children[0].setAttribute("aria-expanded", "true");
                        parentCollapse = parentCollapse.parentElement.closest(".collapse.menu-dropdown");
                        if (parentCollapse) {
                            parentCollapse.classList.add("show");
                            if (parentCollapse.previousElementSibling) {
                                parentCollapse.previousElementSibling.classList.add("active");
                            }
                            parentCollapse = parentCollapse.parentElement.closest(".collapse.menu-dropdown");
                            if (parentCollapse) {
                                parentCollapse.classList.add("show");
                                if (parentCollapse.previousElementSibling) {
                                    parentCollapse.previousElementSibling.classList.add("active");
                                }
                            }
                        }
                    }
                }
            }

            document.getElementById("two-column-menu").innerHTML = ulElement.outerHTML;
            Array.from(document.querySelector("#two-column-menu ul").querySelectorAll("li a")).forEach(function(linkElement) {
                let currentPath = location.pathname === "/" ? "index.html" : location.pathname.substring(1);
                currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
                linkElement.addEventListener("click", function(e) {
                    if (currentPath !== "/" + linkElement.getAttribute("href") || linkElement.getAttribute("data-bs-toggle")) {
                        document.body.classList.remove("twocolumn-panel");
                        document.getElementById("navbar-nav").classList.remove("twocolumn-nav-hide");
                        document.querySelector(".hamburger-icon").classList.remove("open");
                    }
                    if (e.target && (e.target.matches("a.nav-icon") || e.target.matches("i"))) {
                        const activeIcon = document.querySelector("#two-column-menu ul .nav-icon.active");
                        if (activeIcon) {
                            activeIcon.classList.remove("active");
                        }
                        const target = e.target.matches("i") ? e.target.closest("a") : e.target;
                        target.classList.add("active");
                        const itemShow = document.querySelector(".twocolumn-item-show");
                        if (itemShow) {
                            itemShow.classList.remove("twocolumn-item-show");
                        }
                        const targetId = target.getAttribute("href").slice(1);
                        const targetElement = document.getElementById(targetId);
                        if (targetElement) {
                            targetElement.parentElement.classList.add("twocolumn-item-show");
                        }
                    }
                    if (currentPath === "/" + linkElement.getAttribute("href") && !linkElement.getAttribute("data-bs-toggle")) {
                        linkElement.classList.add("active");
                        document.getElementById("navbar-nav").classList.add("twocolumn-nav-hide");
                        document.querySelector(".hamburger-icon").classList.add("open");
                    }
                });
            });
        }

        if (document.documentElement.getAttribute("data-layout") !== "horizontal") {
            const navbarNav = document.getElementById("navbar-nav");
            if (navbarNav) {
                new SimpleBar(navbarNav).getContentElement();
            }
            const iconView = document.getElementsByClassName("twocolumn-iconview")[0];
            if (iconView) {
                new SimpleBar(iconView).getContentElement();
            }
        }
    }

    function c(e) {
        if (e.target && e.target.matches("a.nav-link span")) {
            const nextElementSibling = e.target.parentElement.nextElementSibling;
            if (nextElementSibling && nextElementSibling.classList.contains("dropdown-custom-right")) {
                nextElementSibling.classList.add("dropdown-custom-right");
                nextElementSibling.classList.remove("show");
                const clone = nextElementSibling.cloneNode(true);
                document.body.appendChild(clone);
                clone.classList.add("show");
                n(clone);
                o(clone);
                clone.classList.add("dropdown-custom-right");
            }
        }
    }

    function O() {
        const hamburgerIcons = document.querySelectorAll(".hamburger-icon");
        Array.from(hamburgerIcons).forEach(function(icon) {
            icon.addEventListener("click", function(e) {
                document.body.classList.toggle("menu");
            });
        });
    }

    o();
    s();
    i();
    O();

    // Attach other event listeners
    /*
    document.getElementById("navbar-nav").addEventListener("click", function(e) {
        c(e);
    });
    */
});
