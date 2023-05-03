let btn = document.querySelectorAll('.btn-change')
btn.forEach(element => {
    element.addEventListener('click', ()=>{
        document.getElementById(element.value).style.display = 'none'
        document.getElementById(`form-${element.value}`).style.display = 'flex'
    })
});