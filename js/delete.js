function ConfirmDelete() {
    if (confirm('Ця дія приведе до видалення поля. Ви хочете це зробити?')) {
    return true;
    } else {
    return false;
    }
}