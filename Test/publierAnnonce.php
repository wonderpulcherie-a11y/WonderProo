<form method="POST"
      action="index.php?action=publierAnnonce">

    <div class="mb-3">
        <label>Titre</label>

        <input
            type="text"
            name="titre"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label>Contenu</label>

        <textarea
            name="contenu"
            class="form-control"
            rows="5"
            required
        ></textarea>
    </div>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Publier
    </button>

</form>