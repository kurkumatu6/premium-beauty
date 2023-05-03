let btn = document.querySelector(".btn-create");
let modal = document.getElementById("modal");
btn.addEventListener("click", () => {
  modal.style.display = "flex";
});

let close = document.querySelectorAll("#close");
close.forEach((element) => {
  element.addEventListener("click", () => {
    modal.style.display = "none";
  });
});
let btn_close = document.querySelectorAll("#btn-close");
btn_close.forEach((element) => {
  element.addEventListener("click", () => {
    modal.style.display = "none";
  });
});
window.addEventListener("click", (event) => {
  if (event.target == modal) {
    modal.style.display = "none";
  }
});

document.addEventListener("keydown", (event) => {
  if (event.key == "Escape") {
    modal.style.display = "none";
  }
});
