<div class="listing--search  search-section">
    <div class="row">
        <div class="col s2 center-align">
            <p>FEATURES</p>
            <a href="#" class="theme-btn">Advanced search</a>
        </div>
        <div class="col s8">
            <div class="row">
                <div class="col s4 range-bar">
                    <p>PRICE</p>
                    <input class="price-range-slider" type="hidden" value="25,75"/>
                </div>
                <div class="col s4 range-bar">
                    <p>BEDROOMS</p>
                    <input class="bedroom-range-slider" type="hidden" value="25,75"/>
                </div>
                <div class="col s4 range-bar">
                    <p>BATHROOMS</p>
                    <input class="bathroom-range-slider" type="hidden" value="25,75"/>
                </div>
            </div>
        </div>
        <div class="col s2 center-align">
            <p>19723 ACTIVE LIstings</p>
            <a href="#" class="theme-btn">search</a>
        </div>
    </div>
</div>
<div class="listing--btn--block col s12">
    <div class="row">
        <div class="col s7">
            <label>Sort By :</label>
            <select>
                <option>Recently Added</option>
                <option>High to Low</option>
                <option>Low to High</option>
            </select>
            <a href="#" class="btn cyan">SOLD</a>
            <a href="#" class="btn green">ACTIVE</a>
        </div>
        <div class="col s5 right-align">
            <div class="total--records">
                <span>{{$results->perPage()}}</span> of <span>{{$results->total()}}</span> Total Properties
            </div>
            <div class="listing--pagination">
                <span><a href="{{$results->previousPageUrl()}}"><<</a></span>
                <span class="active">{{$results->currentPage()}}</span>
                <span><a href="{{$results->nextPageUrl()}}">>></a></span>
            </div>
        </div>
        <div class="col s12 listing--tags">
            <span>Active</span>
            <span>Price : low to high</span>
            <a href="#" class=" btn btn-sm theme-btn">CLEAR ALL</a>
        </div>
    </div>
</div>
