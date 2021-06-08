import Filter from './Filter.js'

export default class RegionFilter extends Filter
{
    constructor($values = [], $compare = false) {
        super();
        this.values = $values;
        this.compare = $compare;
    }

    currentValue() {
        return this.values.join(",")
    }

    static getCookieName()
    {
        return "region";
    }
}