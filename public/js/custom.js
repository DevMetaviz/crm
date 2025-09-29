function formatNumber(number, decimals = 2, locale = 'en-US') {
    return number.toLocaleString(locale, {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}

function parseFormattedNumber(value) {
    if (!value) return 0;
    // Remove commas and any other non-numeric characters except decimal point
    var cleaned = value.toString().replace(/[^\d.-]/g, '');
    return parseFloat(cleaned) || 0;
}




// ---------------------- Single Enter handler (handles table + global) ----------------------

$(document).on('keydown', 'input, select, textarea', function(e) {
    if (e.key !== 'Enter') return; // only handle Enter

    let $el = $(this);

   // let $form = $el.closest('.enter-nav-form'); // scoped only
    //if (!$form.length) return;

    // Helper: visible & enabled filter for jQuery selections
    function visibleEnabled(selector) {
        return selector.filter(':visible:not([disabled]):not(.skip-enter)');
    }

    // If inside items table (.add-lines-table), handle row navigation / add-row
    let $row = $el.closest('tr');
    let $table = $el.closest('.add-lines-table');
    if ($table.length && $row.length) {
        e.preventDefault(); // we'll manage navigation

        // fields in current row
        let $rowFields = visibleEnabled($row.find('input, select, textarea'));
        let idx = $rowFields.index($el);

        // 1) If not last field in this row -> move to next field in row
        if (idx > -1 && idx + 1 < $rowFields.length) {
            let $next = $rowFields.eq(idx + 1);
            if ($next.is('select') && $next.hasClass('select2-hidden-accessible')) {
                try { $next.select2('open'); } catch (err) { $next.focus(); }
            } else {
                $next.focus();
            }
            return false;
        }

        // 2) It's last field in this row. Determine if this row is the last row in tbody
        let $tbody = $row.closest('tbody').length ? $row.closest('tbody') : $table;
        let $lastRow = $tbody.find('tr').last();
        let isLastRow = $row.is($lastRow);

        // If it's the last row -> add new row and focus its first field
        if (isLastRow) {
            // only trigger addRow if user pressed Enter on a "last-input" OR simply the last field
            if (!$el.hasClass('last-input') && idx !== $rowFields.length - 1) {
                // safety: if it's not recognized as last-input, still allow global flow
                // but we handled the row's own navigation above, so return
                return false;
            }

            // trigger your add-row logic (existing button or function)
            $('#addRow').trigger('click');

            // focus the first field of newly added row.
            // Use MutationObserver to detect the appended <tr> reliably (handles async addRow)
            if ($tbody && $tbody[0]) {
                let observer;
                let focused = false;

                function focusFirstFieldInRow(node) {
                    let $newRow = $(node);
                    if (!$newRow.length) return;
                    let $first = visibleEnabled($newRow.find('select, input, textarea')).first();
                    if (!$first.length) return;
                    // if it's a select and not yet initialized as select2, try to init
                    if ($first.is('select') && !$first.hasClass('select2-hidden-accessible')) {
                        try { $first.select2(); } catch (err) {}
                    }
                    if ($first.is('select') && $first.hasClass('select2-hidden-accessible')) {
                        try { $first.select2('open'); } catch (err) { $first.focus(); }
                    } else {
                        $first.focus();
                    }
                    focused = true;
                }

                try {
                    observer = new MutationObserver(function(mutations) {
                        for (const m of mutations) {
                            for (const node of m.addedNodes) {
                                if (node.nodeType === 1 && node.matches && node.matches('tr')) {
                                    observer.disconnect();
                                    focusFirstFieldInRow(node);
                                    return;
                                }
                            }
                        }
                    });
                    observer.observe($tbody[0], { childList: true });

                    // fallback timeout in case MutationObserver doesn't catch (350ms)
                    setTimeout(function() {
                        if (observer) observer.disconnect();
                        if (focused) return;
                        let $fallback = $tbody.find('tr').last();
                        focusFirstFieldInRow($fallback);
                    }, 350);

                } catch (err) {
                    // if MutationObserver not available, use simple timeout fallback
                    setTimeout(function() {
                        let $fallback = $tbody.find('tr').last();
                        let $first = visibleEnabled($fallback.find('select, input, textarea')).first();
                        if ($first.length) {
                            if ($first.is('select') && !$first.hasClass('select2-hidden-accessible')) {
                                try { $first.select2(); } catch (e) {}
                            }
                            if ($first.is('select') && $first.hasClass('select2-hidden-accessible')) {
                                try { $first.select2('open'); } catch (e) { $first.focus(); }
                            } else {
                                $first.focus();
                            }
                        }
                    }, 350);
                }
            }

            return false;
        }

        // 3) Last field but NOT last row -> go to next global focusable (simulate Tab)
        {
            let $form = $el.closest('form');
            if ($form.length) {
                let all = visibleEnabled($form.find('input, select, textarea, button'));
                let gi = all.index(this);
                if (gi > -1 && gi + 1 < all.length) {
                    let $nextGlobal = all.eq(gi + 1);
                    if ($nextGlobal.is('select') && $nextGlobal.hasClass('select2-hidden-accessible')) {
                        try { $nextGlobal.select2('open'); } catch (err) { $nextGlobal.focus(); }
                    } else {
                        $nextGlobal.focus();
                    }
                }
            }
            return false;
        }
    } // end items-table block

    // ---------------- Global Enter-as-Tab (not inside .add-lines-table) ----------------
    e.preventDefault();
    let $form = $el.closest('form');
    if (!$form.length) return false;

    let focusable = $form.find('input, select, textarea')
        .filter(':visible:not([disabled]):not(.skip-enter)');
    let index = focusable.index(this);

    if (index > -1 && index + 1 < focusable.length) {
        let $next = focusable.eq(index + 1);
        if ($next.is('select') && $next.hasClass('select2-hidden-accessible')) {
            try { $next.select2('open'); } catch (err) { $next.focus(); }
        } else {
            $next.focus();
        }
    }

    return false;
});

// keep select2 selection behavior (after selecting an option -> move forward)
$(document).on('select2:select', 'select', function () {
    let $form = $(this).closest('form');
    let focusable = $form.find('input, select, textarea')
        .filter(':visible:not([disabled]):not(.skip-enter)');
    let index = focusable.index(this);

    if (index > -1 && index + 1 < focusable.length) {
        let $next = focusable.eq(index + 1);
        if ($next.is('select') && $next.hasClass('select2-hidden-accessible')) {
            try { $next.select2('open'); } catch (err) { $next.focus(); }
        } else {
            $next.focus();
        }
    }
});

// Keep select2 navigation scoped
/*$(document).on('select2:select', '.enter-nav-form select', function () {
    let $form = $(this).closest('.enter-nav-form');
    let focusable = $form.find('input, select, textarea')
        .filter(':visible:not([disabled]):not(.skip-enter)');
    let index = focusable.index(this);

    if (index > -1 && index + 1 < focusable.length) {
        let $next = focusable.eq(index + 1);
        if ($next.is('select') && $next.hasClass('select2-hidden-accessible')) {
            try { $next.select2('open'); } catch (err) { $next.focus(); }
        } else {
            $next.focus();
        }
    }
});*/




