const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
const themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");
const themeToggleBtn = document.getElementById("theme-toggle");
const htmlElement = document.documentElement;
const COLOR_THEME_KEY = "color-theme";
const DARK = "dark";
const LIGHT = "light";

const setTheme = (theme) => {
    localStorage.setItem(COLOR_THEME_KEY, theme);
    htmlElement.classList.toggle(DARK, theme === DARK);
    if (themeToggleDarkIcon && themeToggleLightIcon) {
        themeToggleDarkIcon.classList.toggle("hidden", theme === DARK);
        themeToggleLightIcon.classList.toggle("hidden", theme === LIGHT);
    }
};

if (themeToggleBtn) {
    const savedTheme = localStorage.getItem(COLOR_THEME_KEY);
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    if (savedTheme === DARK || (!savedTheme && prefersDark)) {
        setTheme(DARK);
    } else {
        setTheme(LIGHT);
    }

    themeToggleBtn.addEventListener("click", () => {
        const currentTheme = localStorage.getItem(COLOR_THEME_KEY);
        setTheme(currentTheme === DARK ? LIGHT : DARK);
    });
}
