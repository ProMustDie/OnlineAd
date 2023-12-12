function process() {
    console.log("Processing image...");

    const fileInput = document.querySelector("#upload");

    // Check if a file is selected
    if (!fileInput.files || fileInput.files.length === 0) {
        console.log('No file selected.');
        return;
    }

    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload = function (event) {
        const imgElement = document.createElement("img");
        imgElement.src = event.target.result;

        imgElement.onload = function (e) {
            const canvas = document.createElement("canvas");
            const MAX_WIDTH = 800;

            const scaleSize = MAX_WIDTH / e.target.width;
            canvas.width = MAX_WIDTH;
            canvas.height = e.target.height * scaleSize;

            const ctx = canvas.getContext("2d");

            ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

            // Set the compression quality to 20%
            const srcEncoded = ctx.canvas.toDataURL("image/jpeg", 0.2);

            // Display the original image
            document.querySelector("#input").src = e.target.src;

            // Display the resized image
            document.querySelector("#output").src = srcEncoded;

            // Calculate and log the sizes
            const originalSize = calcImageSize(e.target.src);
            const newSize = calcImageSize(srcEncoded);

            console.log('Original Image Size:', originalSize, 'KB');
            console.log('Resized Image Size:', newSize, 'KB');
        };
    };
}
