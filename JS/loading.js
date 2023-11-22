window.addEventListener("load", () => {
    // Select all elements with the class 'dynamic-input'
    const inputs = document.querySelectorAll(".dynamic-input");
    const loader = document.querySelector(".loader");

    // Iterate through each input element
    inputs.forEach((input) => {
        // Attach a click event listener to each input
        input.addEventListener("click", (event) => {
            // Get the ID of the clicked input
            const inputId = event.target.id;

            // Log the ID to the console (you can perform other actions here)
            console.log("Clicked Input ID:", inputId);

            // Now you can use inputId to perform actions specific to the clicked input
            loader.classList.remove("loader-hidden");

            loader.addEventListener("transitionend", () => {
                if (!loader.classList.contains("loader-hidden")) {
                    // Content is loaded, you can add your logic here
                    console.log("Content loaded");
                }
            });
        });
    });
});
