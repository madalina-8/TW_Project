export default class ColorManager {
    constructor() {
        this.colors = ["#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#00FFFF", "#FF00FF"]
        // red        green      blue       yellow     cyan       magenta
        this.colorsIterator = 0

        this.borderColors = ["#00FF00", "#FF0000", "#FFFF00", "#0000FF", "#FF00FF", "#00FFFF"]
        //green       red        yellow      blue      magenta     cyan
        this.borderColorsIterator = 0
    }

    iterateColorsAndIncrement(ch) {
        let valueToReturn = ch.colorsIterator
        if(ch.colorsIterator < ch.colors.length - 1) {
            ch.colorsIterator = ch.colorsIterator + 1
        } else {
            ch.colorsIterator = 0
        }
        return valueToReturn
    }

    iterateBorderColorsAndIncrement(ch) {
        let valueToReturn = ch.borderColorsIterator
        if(ch.borderColorsIterator < ch.borderColors.length - 1) {
            ch.borderColorsIterator = ch.borderColorsIterator + 1
        } else {
            ch.borderColorsIterator = 0
        }
        return valueToReturn
    }

    getXColors(x, func, ch) {
        const colorsList = [];
        while(x > 0) {
            colorsList.push(ch.colors[func(ch)])
            x = x-1
        }
        return colorsList
    }

}