<script id="js-alert-template" type="text/x-handlebars-template">
{{#if errors}}
    {{#each errors}}
    <li>{{.}}</li>
    {{/each}}
{{else}}
    {{text}}
{{/if}}
</script>