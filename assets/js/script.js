document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.querySelector('#add-product');
    const list = document.querySelector('#product-list');
    if (addButton && list) {
        addButton.addEventListener('click', () => {
            const first = list.querySelector('.product-row');
            const clone = first.cloneNode(true);
            clone.querySelectorAll('input').forEach(input => input.value = '');
            clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            list.appendChild(clone);
            updateRemoveButtons();
        });
        list.addEventListener('click', event => {
            if (event.target.classList.contains('remove-product')) {
                const rows = list.querySelectorAll('.product-row');
                if (rows.length > 1) event.target.closest('.product-row').remove();
                updateRemoveButtons();
            }
        });
        function updateRemoveButtons() {
            const rows = list.querySelectorAll('.product-row');
            rows.forEach(row => {
                const button = row.querySelector('.remove-product');
                if (button) button.disabled = rows.length === 1;
            });
        }
        updateRemoveButtons();
    }
    document.querySelectorAll('[data-confirm]').forEach(button => {
        button.addEventListener('click', event => {
            if (!confirm(button.dataset.confirm)) event.preventDefault();
        });
    });
});
