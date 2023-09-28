<style>
    .texts {
        padding: .5em;
        margin-left: 3px;
        font-size: 15px;
        background: transparent;
        border: 1px solid grey;
        border-radius: 10px;
        color: #fff;
    }

    .filtercontainer {
        background: transparent;
    }




    .lowbox,
    .filter-search .upbox {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        gap: .5rem;
    }

    .title-container label {
        color: white;
    }

    .lowbox {
        position: relative;
        z-index: 1;
        flex-grow: 1;
    }

    .itemsearch {
        background-color: white;
        padding: 4px;
        font-style: italic;
    }

    .searchdroplist {
        display: none;
        padding: 1rem;
        position: absolute;
        background-color: white;
        z-index: 999;
        color: black;
        top: 100%;
        left: 2rem;
        border-radius: 10px;
        /* Adjust the border radius */
    }


    .itemsearch:hover {
        background-color: whitesmoke;
        color: black;
        cursor: pointer;
    }

    /* Style for the title container */
    .title-container {
        background-image: url('./systemImg/5-dots.webp');
        /* Background color (Coral) */
        text-align: center;
        /* Center-align text */
        padding: 2rem 4rem;
    }

    /* Style for the title text */
    .title-text {
        font-family: 'Pacifico', cursive;
        /* Custom font (Pacifico) */
        font-size: 2.5em;
        /* Font size */
        color: white;
        /* Text color (white) */
        text-transform: uppercase;
        /* Uppercase text */
        letter-spacing: 5px;
        /* Letter spacing */
        margin: 0;
    }
</style>

<div class="title-container">
    <h1 class="title-text p-5">BOOK COLLECTION 📚</h1>
    <div class="filtercontainer">
        <form class="filter-search row ">

            <div class="upbox col-5">
                <label class="text-nowrap" for='select'>search Book by </label>

                <select id="select" class="form-select">
                    <option selected value="title">Title</option>
                    <option value="author">Author</option>
                    <option value="ISBN">Isbn</option>
                </select>

            </div>
            <div class='lowbox col-7'>
                <label for='search'>for</label>

                <input type="search" class='texts' name="search" id="search" placeholder="anything...." autocomplete="off">
                <div class='searchdroplist'></div>
            </div>

        </form>
    </div>
</div>