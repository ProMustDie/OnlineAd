<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            transition: opacity 0.75s, visibility 0.75s;
        }

        .loader-hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: blue;
            border-radius: 50%;
            animation: loading 0.75s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }
    </style>
</head>

<body>
    <button id="loadButton">Load Content</button>

    <div class="loader loader-hidden"></div>

    <script>
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");
            const loadButton = document.getElementById("loadButton");

            loadButton.addEventListener("click", () => {
                loader.classList.remove("loader-hidden");
            });

            loader.addEventListener("transitionend", () => {
                if (!loader.classList.contains("loader-hidden")) {
                    // Content is loaded, you can add your logic here
                    console.log("Content loaded");
                }
            });
        });
    </script>
</body>

</html>