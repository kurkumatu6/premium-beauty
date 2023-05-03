let btn = document.querySelectorAll('.edit-btn')
btn.forEach(element => {
    element.addEventListener('click', ()=>{
        document.getElementById(element.value).style.display = 'none'
        document.getElementById(`form-${element.value}`).style.display = 'flex'
    })
});

let btnNot = document.querySelector("#btn_review_not");
let modal = document.getElementById("modal");
btnNot.addEventListener("click", () => {
  modal.style.display = "flex";
});

let close = document.getElementById("close");
close.addEventListener("click", () => {
  modal.style.display = "none";
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
let btn_close = document.getElementById("btn-close");
btn_close.addEventListener("click", () => {
  modal.style.display = "none";
});