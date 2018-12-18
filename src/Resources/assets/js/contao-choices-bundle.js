import Choices from 'choices.js';
import {u, ajax} from 'umbrellajs';

class ChoicesBundle {
    static init() {
        let elements = u('[data-choices="1"]');

        if (elements.length < 1)
        {
            return;
        }

        elements.each(function(node, index) {
            let options = JSON.parse(u(node).attr('data-choices-options'));

            new Choices(node, options);
        });
    }
}

ChoicesBundle.init();