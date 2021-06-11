function updateSelection(choiceBoxId, selectionsTextBoxId) {
    let choiceBox = document.querySelector('#' + choiceBoxId)
    let selectionTextBox = document.querySelector('#' + selectionsTextBoxId)

   /* let values = selectionTextBox.valueOf().value.split(',')
    let newValue = choiceBox.valueOf().value;

    if (newValue === '-')
        return

    if (values.includes(newValue)) {
        let index = values.indexOf(newValue);
        values.splice(index, 1);
    } else {
        values.push(newValue)
    }

    selectionTextBox.valueOf().value = values.sort().join(',')
    choiceBox.valueOf().value = '-'*/

    if(selectionTextBox.valueOf().value !== "")
        selectionTextBox.valueOf().value = selectionTextBox.valueOf().value + "," +  choiceBox.valueOf().value
    else
        selectionTextBox.valueOf().value = choiceBox.valueOf().value
}