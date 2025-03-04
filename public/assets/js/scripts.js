document.addEventListener("DOMContentLoaded", function () {
    var deleteModal = document.getElementById("deleteModal");

    if (deleteModal) {
        deleteModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; 
            var articleId = button.getAttribute("data-id");
            var articleTitle = button.getAttribute("data-title");

            document.getElementById("articleTitle").textContent = articleTitle;
            document.getElementById("confirmDelete").href = "article_delete.php?id=" + articleId;
        });
    }
});
