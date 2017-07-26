<?php

namespace Startkit\Titles;

/**
 * Page titles
 */
function page_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', 'startkit');
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', 'startkit'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', 'startkit');
  } else {
    return get_the_title();
  }
}
