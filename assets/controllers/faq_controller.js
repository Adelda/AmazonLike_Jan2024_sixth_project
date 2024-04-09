import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['answer'];

    toggle() {
        const el = this.answerTarget;
        
        if (el.ownerDocument.defaultView.getComputedStyle(el, null).display === 'none') {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    }
}
