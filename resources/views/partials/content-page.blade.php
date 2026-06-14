<div class="entry-content wp-block-post-content is-layout-constrained has-global-padding">
  @php(the_content())
</div>

@if ($pagination())
  <nav class="page-nav" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
