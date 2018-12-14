import Choices from 'choices.js';
import u from 'umbrellajs';

class ChoicesBundle {
    static init() {
        if (u('[data-choices="1"]').length < 1)
        {
            return;
        }

        new Choices('[data-choices="1"]');
    }
}

ChoicesBundle.init();