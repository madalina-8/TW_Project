import Filter from './Filter.js'

export default class SexFilter extends Filter
{
    constructor($values = [], $compare = false) {
        super();
        this.values = $values;
        this.compare = $compare;
    }

    static getCookieName()
    {
        return "sexSelections";
    }
}