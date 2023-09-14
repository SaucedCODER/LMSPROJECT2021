<style>
    .texts {
        padding: .5em;
        margin-left: 3px;
        font-size: 15px;
        background: transparent;
        border: 1px solid grey;
        border-radius: 10px;
        color: grey;
    }

    .filter-search {
        display: flex;
        flex-wrap: wrap;
        /* Stack elements vertically on smaller screens */
        color: white;
        gap: 1rem;
        padding: 1rem;
        width: 100%;
        /* Add some padding for spacing */
        background-color: black;
    }


    .lowbox,
    .filter-search .upbox {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .5rem;
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


    #select {
        font-weight: bold;
    }

    .itemsearch:hover {
        background-color: whitesmoke;
        color: black;
        cursor: pointer;
    }
</style>


<form class="filter-search">

    <div class="upbox">
        <label>search Book by </label>

        <select id="select" class='texts'>
            <option value="title">title</option>
            <option value="author">author</option>
            <option value="ISBN">ISBN</option>
        </select>

    </div>
    <div class='lowbox'>
        <label>for</label>

        <input type="search" class='texts' name="search" id="search" placeholder="anything...." autocomplete="off">
        <div class='searchdroplist'></div>
    </div>

</form>