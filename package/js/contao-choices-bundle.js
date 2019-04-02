import Choices from 'choices.js';

class ChoicesBundle {
    static init()
    {
        if (!ChoicesBundle.hasOwnProperty('choiceInstances'))
        {
            ChoicesBundle.choiceInstances = [];
        }
        let elements = document.querySelectorAll('[data-choices="1"]');
        if (elements.length < 1)
        {
            return;
        }
        elements.forEach((element) => {
            let options = {};
            if (element.hasAttribute('data-choices-options')){
                options.assign(JSON.parse(element.getAttribute('data-choices-options')));
            }
            let choice = new Choices(element, options);
            ChoicesBundle.choiceInstances.push({element: element, instance: choice})
        })
    }
    static getChoiceInstances() {
        return ChoicesBundle.choiceInstances;
    }
}

export { ChoicesBundle };