# Cilla Skyn General Information Block

A single freeform rich-text section — one full WYSIWYG field, instead of a fixed set of eyebrow/heading/paragraph fields, so the client can write and format any general-purpose copy without needing a new field (or a new block) for every new piece of text. Formerly named "Our Story" and built from separate eyebrow/heading/paragraph-repeater/pronunciation/closing-line fields; this version replaces all of that with one editor and ships with that same founder-story copy as its default content so nothing is lost.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Content** | WYSIWYG | No | Full rich-text editor — bold/italic, headings (H2–H6), bullet/numbered lists, links, blockquotes, "Add Media" for images/files, or paste a YouTube/Vimeo link on its own line to embed a video. Ships with the original "Our Story" copy as its default. |

## Styling

The Content field's HTML (whatever headings/paragraphs/lists/links/images the editor produces) is rendered through the same `the_content` pipeline WordPress uses for normal post content, then styled as a scoped "prose" ruleset in `src/input.css` under `.wp-theme-cilla-skyn-general-information__content` — serif headings, spaced paragraphs, restored list markers, gold-underline links — since raw editor output can't carry Tailwind utility classes directly. The section itself is a narrow (`max-w-2xl`) reading column on the cream-dark background, matching the rest of the About-page block stack.
