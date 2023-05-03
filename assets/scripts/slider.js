let idPhoto = 0;
let max = document.getElementById("count-photo").textContent;
let left = document.getElementById("left");
let right = document.getElementById("right");
let photo = document.querySelectorAll(".slider-photo");
left.addEventListener("click", () => {
  if (idPhoto == 0) {
    idPhoto = max;
    document.getElementById(idPhoto).style.display = "block";
    document.getElementById(0).style.display = "none";
  } else {
    idPhoto -= 1;
    document.getElementById(idPhoto).style.display = "block";
    document.getElementById(idPhoto + 1).style.display = "none";
  }
});
right.addEventListener("click", () => {
  if (idPhoto == max) {
    idPhoto = 0;
    document.getElementById(idPhoto).style.display = "block";
    document.getElementById(max).style.display = "none";
  } else {
    idPhoto += 1;
    document.getElementById(idPhoto).style.display = "block";
    document.getElementById(idPhoto - 1).style.display = "none";
  }
});
