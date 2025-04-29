document.addEventListener("DOMContentLoaded", () => {
    const tabLinks = document.querySelectorAll(".tab-link");
    const tabContents = document.querySelectorAll(".tab-content");
    if (tabContents.length > 0 && tabLinks.length > 0) {
        const activateTab = (tabId) => {
            tabContents.forEach(content => {
                content.classList.add("hidden");
            });
            document.getElementById(tabId).classList.remove("hidden");

            tabLinks.forEach(tab => {
                tab.classList.remove("border-b-2", "border-blue-500", "text-blue-500");
                tab.classList.add("text-gray-600", "dark:text-gray-300");
            });

            const activeTab = document.querySelector(`.tab-link[data-tab="${tabId}"]`);
            if (activeTab) {
                activeTab.classList.remove("text-gray-600", "dark:text-gray-300");
                activeTab.classList.add("border-b-2", "border-blue-500", "text-blue-500");
            }
        };
        tabLinks.forEach(tab => {
            tab.addEventListener("click", function() {
                activateTab(this.getAttribute("data-tab"));
            });
        });
        activateTab(tabLinks[0].getAttribute("data-tab"));
    }
});