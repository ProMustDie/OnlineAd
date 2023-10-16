function openModal(imgSrc, altText) {
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("modalImg");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = imgSrc;
    captionText.innerHTML = altText;
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}