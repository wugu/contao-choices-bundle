import { ChoicesBundle } from '../../npm-package';

document.addEventListener('DOMContentLoaded', ChoicesBundle.init);
document.addEventListener('filterAjaxComplete', ChoicesBundle.init);
document.addEventListener('formhybridToggleSubpaletteComplete', ChoicesBundle.init)