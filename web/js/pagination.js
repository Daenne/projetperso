var ias = jQuery.ias({
        container:  '#all_articles',
        item:       '.article',
        pagination: '#pagination',
        next:       '.next'
      });
      ias.extension(new IASSpinnerExtension());
      ias.extension(new IASNoneLeftExtension({
          text: "Plus aucun article à charger..."
      }));
      ias.extension(new IASTriggerExtension({
          text: "Afficher plus d'articles",
          offset: 3
      }));