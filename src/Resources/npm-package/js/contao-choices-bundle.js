import Choices from 'choices.js';

class ChoicesBundle
{
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
            let defaultOptions = {};
            if (element.hasAttribute('data-choices-options')) {
                let options = JSON.parse(element.getAttribute('data-choices-options'));
                if (options.hasOwnProperty('addItemTextString'))
                {
                    options.addItemText = (value) => {
                        return options.addItemTextString;
                    },
                    delete options.addItemTextString;
                }
                if (options.hasOwnProperty('maxItemTextString'))
                {
                    options.maxItemText = (maxItemCount) => {
                        return options.maxItemTextString;
                    },
                    delete options.maxItemTextString;
                }
                defaultOptions = Object.assign(defaultOptions, options);
            }
            let choice = new Choices(element, defaultOptions);
            ChoicesBundle.choiceInstances.push({element: element, instance: choice})
        })
    }

    static getChoiceInstances()
    {
        return ChoicesBundle.choiceInstances;
    }
}

export { ChoicesBundle };