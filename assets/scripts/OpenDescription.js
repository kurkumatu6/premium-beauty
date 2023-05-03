let btn = document.querySelectorAll('.description-btn');

btn.forEach(element => {
    element.addEventListener('click', ()=>{
        if(element.textContent == 'Показать описание'){
            document.getElementById(`desc-${element.id}`).style.display = 'block'
            element.textContent = 'Скрыть'
        }
        else{
            document.getElementById(`desc-${element.id}`).style.display = 'none'
            element.textContent = 'Показать описание'
        }
        
    })
});