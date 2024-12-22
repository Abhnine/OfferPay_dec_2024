var elems = document.getElementsByClassName('csm-delete-confirmation');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to delete?')) e.preventDefault();
};
for (var i = 0, l = elems.length; i < l; i++) {
    elems[i].addEventListener('click', confirmIt, false);
}

var approve = document.getElementsByClassName('csm-approve');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to approve?')) e.preventDefault();
};
for (var i = 0, l = approve.length; i < l; i++) {
    approve[i].addEventListener('click', confirmIt, false);
}

var rejact = document.getElementsByClassName('csm-rejact');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to rejact?')) e.preventDefault();
};
for (var i = 0, l = rejact.length; i < l; i++) {
    rejact[i].addEventListener('click', confirmIt, false);
}

var complete = document.getElementsByClassName('csm-complete');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to complete?')) e.preventDefault();
};
for (var i = 0, l = complete.length; i < l; i++) {
    complete[i].addEventListener('click', confirmIt, false);
}

var block = document.getElementsByClassName('csm-block');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to block?')) e.preventDefault();
};
for (var i = 0, l = block.length; i < l; i++) {
    block[i].addEventListener('click', confirmIt, false);
}

var unblock = document.getElementsByClassName('csm-unblock');
var confirmIt = function (e) {
    if (!confirm('Are you sure do you want to unblock?')) e.preventDefault();
};
for (var i = 0, l = unblock.length; i < l; i++) {
    unblock[i].addEventListener('click', confirmIt, false);
}
