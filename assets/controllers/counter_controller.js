import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.textContent = 'Você clicou  0 vezes';
        this.count = 0;
        this.element.addEventListener('click', ()=>{
            this.count++;
            this.element.innerHTML = 'Você clicou '+this.count +'  vezes ';
        })
    }
}
