    <!-- search -->
    <section>
        <form action="./search" method="GET" class="car-search">
            <fieldset class="small-input">
                <label for="engine">Select Model:</label>
                <br>
                <select name="engine" id="engine">
                    <option value="Engine" name="Diesel">Engine</option>
                    <option value="Electric" name="Electric">Electric</option>
                    <option value="Hybrid" name="Hybrid">Hybrid</option>
                </select>
            </fieldset>
            <fieldset>
                <label for="status">pricing</label>
                <br>
                <select name="price" id="price">
                    <option value="50" name="2020">$50,000 - $100,000</option>
                    <option value="100" type="year" name="year"> $100,000 - $300,000</option>
                    <option value="300" name="2022">$300,000 - $600,000</option>
                    <option value="700" name="2023">$700,000+</option>
                </select>
            </fieldset>
            <fieldset>
                <button type="submit" class="search-button">Search Car</button>
        </form>
        </fieldset>
        </form>
    </section>