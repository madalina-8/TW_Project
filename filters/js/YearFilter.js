import Filter from './Filter.js'

export default class YearFilter extends Filter
{
    constructor($values = [], $compare = false) {
        super();
        this.values = $values;
        this.compare = $compare;
    }

    static getCookieName()
    {
        return "yearSelections";
    }
}