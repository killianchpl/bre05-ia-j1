export default function initMap(rows, cols) {
    let $main = null;
    let $box = null;
    let $id = 0;

    for (var i = 0; i < rows; ++i) {
        for (var j = 0; j < cols; ++j) {
            $main = document.querySelector("main");
            $box = document.createElement("section");
            $box.classList.add("col-start-" + (j + 1));
            $box.classList.add("col-end-" + (j + 1));
            $box.classList.add("row-start-" + (i + 1));
            $box.classList.add("row-end-" + (i + 1));
            $box.setAttribute("id", $id);
            $main.appendChild($box);
            $id++;
        }
    }
}
