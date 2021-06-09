function updateSelection(choiceBoxId, selectionsTextBoxId) {
    let choiceBox = document.querySelector('#' + choiceBoxId)
    let selectionTextBox = document.querySelector('#' + selectionsTextBoxId)
    if(selectionTextBox.valueOf().value !== "")
        selectionTextBox.valueOf().value = selectionTextBox.valueOf().value + ", " +  choiceBox.valueOf().value
    else
        selectionTextBox.valueOf().value = choiceBox.valueOf().value
}