let btnBooking = document.getElementById('btn-booking')
let description = document.getElementById('description')
let divBooking = document.querySelector('.booking')
let btnTwo = document.querySelector('.two')
let cancel = document.getElementById('cancel')
btnBooking.addEventListener("click", () =>{
    description.style.display = 'none'
    divBooking.style.display = 'block'
    btnTwo.style.display = 'none'
})
cancel.addEventListener("click", () =>{
    description.style.display = 'block'
    divBooking.style.display = 'none'
    btnTwo.style.display = 'block'
})
