import './styles/app.css';
import './stimulus_bootstrap.js';
import '@hotwired/turbo';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.addEventListener('turbo:load', () => {

    document.querySelectorAll('.flash').forEach((flash) => {

        setTimeout(() => {

            flash.classList.add('hide');

            setTimeout(() => {
                flash.remove();
            }, 500);

        }, 4000);

    });

});
