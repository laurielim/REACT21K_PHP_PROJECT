(function () {
	const jsonContainer = document.getElementById("jsonContainer");
	function syntaxHighlight(json) {
		json = json
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;");
		return json.replace(
			/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
			function (match) {
				var cls = "number";
				if (/^"/.test(match)) {
					if (/:$/.test(match)) {
						cls = "key";
					} else {
						cls = "string";
					}
				} else if (/true|false/.test(match)) {
					cls = "boolean";
				} else if (/null/.test(match)) {
					cls = "null";
				}
				return '<span class="' + cls + '">' + match + "</span>";
			}
		);
	}
	const recipeExample = {
		"@context": "http://schema.org/",
		"@type": "Recipe",
		id: 101,
		name: "old fashioned",
		image: {
			url: "https://source.unsplash.com/qAegSdhKwnE/500x320",
			source: "https://unsplash.com/photos/qAegSdhKwnE",
			author: "Johann Trasch",
			license: "the Unsplash License",
		},
		recipeCategory: "the unforgettables",
		description:
			"The old fashioned is a cocktail made by muddling sugar with bitters and water, adding whiskey or, less commonly, brandy, and garnishing with orange slice or zest and a cocktail cherry. It is traditionally served in an old fashioned glass (also known as rocks glass), which predated the cocktail.",
		recipeIngredient: [
			{
				id: 1,
				ingredient: "bourbon",
				quantity: "4.5 cl",
			},
			{
				id: 2,
				ingredient: "angostura bitters",
				quantity: "2 dashes",
			},
			{
				id: 3,
				ingredient: "sugar cube",
				quantity: "1",
			},
			{
				id: 4,
				ingredient: "plain water",
				quantity: "1 dash",
			},
		],
		recipeGarnish: "orange slice or zest, and cocktail cherry",
		recipeInstructions: [
			{
				"@type": "HowToStep",
				id: 1,
				step: "place sugar cube in old fashioned glass.",
			},
			{
				"@type": "HowToStep",
				id: 2,
				step: "saturate with bitters.",
			},
			{
				"@type": "HowToStep",
				id: 3,
				step: "add a dash of plain water.",
			},
			{
				"@type": "HowToStep",
				id: 4,
				step: "muddle until dissolved.",
			},
			{
				"@type": "HowToStep",
				id: 5,
				step: "fill the glass with ice cubes and add whiskey.",
			},
			{
				"@type": "HowToStep",
				id: 6,
				step: "garnish with lemon wedge.",
			},
		],
	};
	jsonContainer.innerHTML = syntaxHighlight(
		JSON.stringify(recipeExample, null, 2)
	);
})();
