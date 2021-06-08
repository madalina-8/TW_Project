function updateSelection(choiceBoxId, selectionsChoiceBoxId) {
    let choiceBox = document.querySelector('#' + choiceBoxId)
    let selectionChoiceBox = document.querySelector('#' + selectionsChoiceBoxId)
    let newOption = new Option(choiceBox.valueOf().value, choiceBox.valueOf().value)
    selectionChoiceBox.appendChild(newOption)
}

function removeCurrentChoice(selectionsChoiceBoxId) {
    let selectionChoiceBox = document.querySelector('#' + selectionsChoiceBoxId)
    selectionChoiceBox.children.item(selectionChoiceBox.valueOf().index).remove()
}