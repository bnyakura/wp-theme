# ACF Blocks Explained — Starting With the Hero Block

This tutorial explains the **whole concept of ACF (Advanced Custom Fields) blocks** in a WordPress theme, using the `Hero` block in `wp-theme` as the concrete example. It walks through every file, every function, and every line of code that makes the block work — from registration, to the field group, to the PHP render template, to the CSS and JavaScript that bring the slider to life.

---

## Table of Contents

1. [What is an ACF block?](#1-what-is-an-acf-block)
2. [The big picture: how the files fit together](#2-the-big-picture-how-the-files-fit-together)
3. [Step 0 — Theme bootstrap: `functions.php`](#3-step-0--theme-bootstrap-functionsphp)
4. [Step 1 — The plugin requirement guard: `inc/acf-requirements.php`](#4-step-1--the-plugin-requirement-guard-incacf-requirementsphp)
5. [Step 2 — Auto-registering blocks: `inc/acf-blocks.php`](#5-step-2--auto-registering-blocks-incacf-blocksphp)
6. [Step 3 — Block metadata: `blocks/hero/block.json`](#6-step-3--block-metadata-blocksheroblockjson)
7. [Step 4 — Field group JSON: `acf-json/group_hero.json`](#7-step-4--field-group-json-acf-jsongroup_herojson)
8. [Step 5 — Local JSON save/load: `inc/acf-json.php`](#8-step-5--local-json-saveload-incacf-jsonphp)
9. [Step 6 — The render template: `blocks/hero/render.php`](#9-step-6--the-render-template-blocksherorenderphp)
10. [Step 7 — Block styles: `blocks/hero/style.css`](#10-step-7--block-styles-blocksherostylecss)
11. [Step 8 — Slider behaviour: `assets/js/hero-slider.js`](#11-step-8--slider-behaviour-assetsjshero-sliderjs)
12. [Step 9 — Global CSS tokens: `src/input.css`](#12-step-9--global-css-tokens-srcinputcss)
13. [Step 10 — Enqueueing scripts: `inc/theme-js.php`](#13-step-10--enqueueing-scripts-inctheme-jsphp)
14. [The full data flow from editor to browser](#14-the-full-data-flow-from-editor-to-browser)
15. [How to create your own block (the pattern)](#15-how-to-create-your-own-block-the-pattern)
16. [Key takeaways / glossary](#16-key-takeaways--glossary)

---

## 1. What is an ACF block?

A **block** is the basic unit of content in the WordPress Gutenberg (block) editor. A *core* block is built-in (Paragraph, Image, Button, etc.). An **ACF block** is a **custom block that you build yourself** using the Advanced Custom Fields plugin.

The key idea: **ACF provides the UI (the field inputs in the editor), and you provide the HTML (how the saved data is rendered on the frontend).**

An ACF block is really three things glued together:

| Piece | What it is | File(s) in this theme |
|---|---|---|
| **1. Registration** | Tells WordPress the block exists, its name, icon, what settings it supports | `block.json` |
| **2. Fields** | The data the editor user can fill in (text, image, repeater…) | `acf-json/group_hero.json` |
| **3. Template** | A PHP file that turns the saved field data into HTML | `render.php` |

Because a block is a **self-contained folder**, you can think of each block as a little component: *data in → HTML out*. Editors fill in the fields in wp-admin, WordPress saves the values in the post's `post_content` (as serialized block markup), and when a visitor loads the page, PHP reads the saved values and echoes the final HTML.

### Why use ACF blocks instead of hard-coded page templates?

- **Editor-friendly**: content editors can add/reorder blocks in Gutenberg without touching code.
- **Reusable**: the same block can be dropped onto many pages with different content.
- **Structured data**: fields are typed (image, URL, repeater), unlike freeform HTML.
- **Versioned**: field groups are stored as JSON in the theme (git-trackable).
- **Autonomous**: each block owns its own styles and render logic.

---

## 2. The big picture: how the files fit together

```
wp-theme/
├── functions.php                  ← entry point, loads everything
├── inc/
│   ├── acf-requirements.php       ← dies if ACF Pro is not installed
│   ├── acf-blocks.php             ← scans /blocks/*/block.json and registers blocks
│   ├── acf-json.php               ← tells ACF where to save/load field JSON
│   ├── acf-options.php            ← (options pages, not covered here)
│   ├── theme-setup.php            ← theme supports, menus, customizer
│   ├── theme-styles.php           ← enqueues compiled CSS
│   └── theme-js.php               ← enqueues JS (incl. hero-slider.js)
├── blocks/
│   └── hero/
│       ├── block.json             ← block metadata + registration
│       ├── render.php             ← frontend HTML template
│       ├── style.css              ← block-scoped CSS
│       └── README.md
├── acf-json/
│   └── group_hero.json            ← the field group (form fields) as JSON
└── assets/
    ├── js/hero-slider.js          ← slider interactivity
    └── css/tailwind.css           ← compiled global CSS (includes keyframes)
```

The lifecycle:

1. Theme loads → `functions.php` pulls in the `inc/` modules.
2. `acf/init` fires → `acf-blocks.php` scans `blocks/*/block.json` and calls `register_block_type()` for each.
3. ACF loads field groups from `acf-json/` (via the `acf/settings/load_json` filter).
4. Editor user adds a "Hero" block → ACF shows the field group form → saves values into the post.
5. Frontend request → WordPress runs the block's `render.php`, passing the saved field values via `get_field()`.
6. `render.php` outputs HTML with `data-hero-*` hooks → CSS in `style.css` styles it → `hero-slider.js` animates it.

Now let's go file by file.

---

## 3. Step 0 — Theme bootstrap: `functions.php`

```php
<?php
/**
 * custom-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package custom-theme
 */

DEFINED( 'CUSTOM_THEME_VERSION' ) OR define( 'CUSTOM_THEME_VERSION', '1.0.1' );

// Define the path to the acf-requirements file
$theme_setup_file_path = get_template_directory() . '/inc/acf-requirements.php';
if( file_exists( $theme_setup_file_path ) ) {
    require $theme_setup_file_path;
}

// Define the path to the theme-setup file
$theme_setup_file_path = get_template_directory() . '/inc/theme-setup.php';
if( file_exists( $theme_setup_file_path ) ) {
    require $theme_setup_file_path;
}

// Define the path to the theme-styles file
$theme_styles_file_path = get_template_directory() . '/inc/theme-styles.php';
if( file_exists( $theme_styles_file_path ) ) {
    require $theme_styles_file_path;
}

//Define path to js files
$theme_js_file_path = get_template_directory() . '/inc/theme-js.php';
if( file_exists( $theme_js_file_path ) ) {
    require $theme_js_file_path;
}

// Define the path to the acf-blocks file
$acf_blocks_file_path = get_template_directory() . '/inc/acf-blocks.php';
if( file_exists( $acf_blocks_file_path ) ) {
    require $acf_blocks_file_path;
}

// Define the path to the acf-json file
$acf_json_file_path = get_template_directory() . '/inc/acf-json.php';
if( file_exists( $acf_json_file_path ) ) {
    require $acf_json_file_path;
}

// Define the path to the acf-options file
$acf_options_file_path = get_template_directory() . '/inc/acf-options.php';
if( file_exists( $acf_options_file_path ) ) {
    require $acf_options_file_path;
}
```

### What each part does

- **`CUSTOM_THEME_VERSION`** — a version constant used for cache busting of scripts/styles later. The `DEFINED(...) OR define(...)` idiom means: *only define it if it isn't already defined*, so plugins or child themes can override it.
- **`get_template_directory()`** — returns the absolute server path of the theme directory (e.g. `/opt/lampp/htdocs/wordpress/wp-content/themes/wp-theme`). This is the "we're on the file system" way to reference the theme, as opposed to `get_template_directory_uri()` which returns a URL.
- **`file_exists()` + `require`** — the theme carefully loads each module only *if the file actually exists*. This is defensive: if a file was deleted, the theme still boots instead of fatally erroring.
- **Order matters**: `acf-requirements.php` is loaded first so ACF dependency is validated before any ACF API is used; the block/JSON modules come last so registration happens after the environment is ready.

This file is the **single entry point** — all of the theme's logic hangs off it.

---

## 4. Step 1 — The plugin requirement guard: `inc/acf-requirements.php`

```php
<?php
/**
 * ACF requirements.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_acf_admin_notice' ) ) {
	function custom_theme_acf_admin_notice(): void {
		?>
		<div class="notice notice-error">
			<p>
				<strong><?php esc_html_e( 'custom-theme:', 'custom-theme' ); ?></strong>
				<?php esc_html_e( 'Advanced Custom Fields Pro is required for this theme to function correctly.', 'custom-theme' ); ?>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'custom_theme_require_acf' ) ) {
	function custom_theme_require_acf(): void {
		$acf_available = function_exists( 'acf' )
			&& function_exists( 'acf_add_options_page' );

		if ( $acf_available ) {
			return;
		}

		// Allow wp-admin access.
		if ( is_admin() ) {
			add_action( 'admin_notices', 'custom_theme_acf_admin_notice' );
			return;
		}

		// Block frontend rendering.
		wp_die(
			wp_kses_post(
				__(
					'<h1>Advanced Custom Fields Pro Required</h1><p>The custom-theme theme requires Advanced Custom Fields Pro to be installed and activated.</p>',
					'custom-theme'
				)
			),
			esc_html__( 'Missing Required Plugin', 'custom-theme' ),
			array( 'response' => 500 )
		);
	}
}
add_action( 'after_setup_theme', 'custom_theme_require_acf', 1 );
```

### What each part does

- **`function_exists()` guards** — because a theme can be loaded twice (e.g. by a child theme) or these functions may already exist elsewhere, each function is wrapped in `if ( ! function_exists(...) )`. This prevents the classic *"Cannot redeclare function"* fatal error.
- **`custom_theme_acf_admin_notice()`** — prints an admin "error" notice in the wp-admin dashboard. `esc_html_e()` = echo + escape + translate (the `_e` suffix means it's a translatable string from the `custom-theme` text domain).
- **`custom_theme_require_acf()`** — the real check:
  - `function_exists('acf')` — the global ACF loader function exists.
  - `function_exists('acf_add_options_page')` — this is a **Pro-only** function, so checking it verifies ACF **Pro** (the free version doesn't have Options Pages). This is how the theme detects "ACF Pro specifically, not just ACF".
  - If both exist → `return`, everything is fine.
  - If in the admin → show the soft notice (admin must still be able to log in and fix things).
  - If on the **frontend** → `wp_die()` with a 500 response. The site refuses to render without ACF Pro, since the entire theme depends on it.
- **`add_action('after_setup_theme', ..., 1)`** — runs very early in the theme lifecycle (priority `1` = first), so the guard kicks in before any block registration.

**Why this matters for blocks:** ACF blocks need ACF's API (`acf_register_block_type`, `get_field()`, the `acf/init` hook). Without the plugin, every block would fatal-error. This file makes the failure mode *clear and early* instead of *confusing and scattered*.

---

## 5. Step 2 — Auto-registering blocks: `inc/acf-blocks.php`

```php
<?php
/**
 * ACF block registration.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_register_acf_blocks' ) ) {
	function custom_theme_register_acf_blocks(): void {
		$blocks_path = get_template_directory() . '/blocks';

		if ( ! function_exists( 'acf_register_block_type' ) || ! is_dir( $blocks_path ) ) {
			return;
		}

		$block_json_files = glob( $blocks_path . '/*/block.json' );

		if ( empty( $block_json_files ) ) {
			return;
		}

		foreach ( $block_json_files as $block_json_file ) {
			register_block_type( dirname( $block_json_file ) );
		}
	}
}
add_action( 'acf/init', 'custom_theme_register_acf_blocks' );
```

### What each part does

- **`custom_theme_register_acf_blocks()`** — the single registration function for *every* block in the theme. This is the "convention over configuration" trick that makes adding a new block as easy as dropping a folder in `/blocks`.
- **`$blocks_path`** — points at the theme's `blocks/` directory.
- **Guard #1**: `function_exists('acf_register_block_type')` — bail if ACF isn't active (defense in depth, on top of `acf-requirements.php`). **Guard #2**: `is_dir()` — bail if `blocks/` is missing.
- **`glob($blocks_path . '/*/block.json')`** — returns an array of all `block.json` paths, one per block folder. `glob` with `*` matches any immediate subdirectory, so `/blocks/hero/block.json`, `/blocks/pricing/block.json`, etc. are all found automatically. **This is the key trick**: you never hand-register a block — you just create a folder with a `block.json` and it's picked up.
- **`register_block_type(dirname($block_json_file))`** — WordPress core function. `dirname()` strips the filename to give the folder path (`/blocks/hero`). When passed a *folder path*, `register_block_type()` reads that folder's `block.json` and registers the block. For ACF blocks, WordPress looks at the `acf` key in `block.json` and wires it up to ACF.
- **`add_action('acf/init', ...)`** — `acf/init` is ACF's own initialization hook. Block types **must** be registered on this hook (or later), never earlier. If you registered on `init`, ACF might not be ready and blocks would fail to appear in the editor.

> **Concept**: `register_block_type()` is what makes the block appear in the Gutenberg inserter. Everything about the block — name, category, icon, render callback, supported settings — is declared declaratively in `block.json` and consumed here.

---

## 6. Step 3 — Block metadata: `blocks/hero/block.json`

```json
{
    "name": "wp-theme/hero",
    "title": "Hero",
    "category": "design",
    "icon": "superhero-alt",
    "description": "A customizable hero banner section.",
    "keywords": ["hero", "banner", "header", "cta"],
    "acf": {
        "mode": "preview",
        "renderTemplate": "render.php"
    },
    "supports": {
        "align": ["wide", "full"],
        "anchor": true,
        "color": {
            "background": true,
            "text": true
        },
        "spacing": {
            "padding": true,
            "margin": true
        }
    },
    "style": "file:./style.css"
}
```

### What each property does

| Property | Value | Meaning |
|---|---|---|
| `name` | `"wp-theme/hero"` | The **unique identifier** of the block. Namespaced `<theme>/<block>` — must match the theme. Used everywhere: registration, the field group location rule, the CSS class, and in `post_content` markup. |
| `title` | `"Hero"` | Human-readable name shown in the block inserter / editor toolbar. |
| `category` | `"design"` | Which section of the block inserter this block appears under. |
| `icon` | `"superhero-alt"` | A Dashicons icon slug shown next to the title. |
| `description` | `"A customizable hero banner section."` | Short helper text in the editor. |
| `keywords` | `["hero", "banner", "header", "cta"]` | Search terms so editors can find the block by typing any of these. |
| `acf.mode` | `"preview"` | `preview` = the editor shows the actual rendered block (live preview). `edit` = shows the field form instead. |
| `acf.renderTemplate` | `"render.php"` | **The most important line.** The PHP template that renders this block. Relative to the block folder. |
| `supports.align` | `["wide", "full"]` | Allows the editor to choose Wide or Full-width alignment. |
| `supports.anchor` | `true` | Adds an HTML anchor field, so the block can be linked to (e.g. `#home`). |
| `supports.color.background/text` | `true` | Lets the editor change background/text colors from the editor panel. |
| `supports.spacing.padding/margin` | `true` | Adds padding/margin controls in the editor. |
| `style` | `"file:./style.css"` | WP automatically enqueues this stylesheet **on the frontend** when the block is present, and in the **editor** so the preview looks right. |

### The `acf` key is the ACF hook

For a *normal* block, `renderTemplate` doesn't exist and the render callback lives in PHP. For an **ACF block**, the `acf` key signals: *"let ACF manage the data for this block, and use `render.php` to draw it."* ACF reads field values inside `render.php` via `get_field()`. That's the entire ACF-block contract:

> **block.json** declares the block; **ACF fields** store the content; **render.php** draws it.

---

## 7. Step 4 — Field group JSON: `acf-json/group_hero.json`

This is a big file, so let's break it into its two top-level sections: the **`fields`** array and the **`location`** rule.

### 7a. The top-level structure

```json
{
    "key": "group_hero",
    "title": "Hero",
    "fields": [ ... ],
    "location": [
        [
            {
                "param": "block",
                "operator": "==",
                "value": "wp-theme/hero"
            }
        ]
    ],
    "menu_order": 0,
    "position": "normal",
    "style": "default",
    "label_placement": "top",
    "instruction_placement": "label",
    "hide_on_screen": "",
    "active": true,
    "description": "Multi-slide hero carousel with background images, headlines, and CTA.",
    "show_in_rest": 0,
    "modified": 0
}
```

| Property | Meaning |
|---|---|
| `key` | The field group's unique machine key (`group_hero`). Referenced when syncing and when ACF stores data. |
| `title` | Shown in **Custom Fields → Field Groups** in wp-admin. |
| `fields` | The actual form inputs (covered next). |
| `location` | **This is what makes it a *block* field group.** The rule says: *"show this form whenever the block `wp-theme/hero` is used."* The `param: "block"` rule type is specifically for ACF blocks. Without this, the fields would be orphaned. |
| `position`, `style`, `label_placement` | UI options: where the box sits on the edit screen, whether it's boxed/default, labels above fields, etc. |
| `show_in_rest` | Whether the field group is exposed in the REST API (0 = no). |
| `modified` | Bookkeeping timestamp ACF uses to decide if JSON is out of sync. |

### 7b. The `Slides` repeater field (the core of the hero)

```json
{
    "key": "field_hero_slides",
    "label": "Slides",
    "name": "slides",
    "type": "repeater",
    "instructions": "Add each slide for the hero carousel.",
    "required": 0,
    "layout": "block",
    "min": 1,
    "max": 10,
    "button_label": "Add Slide",
    "sub_fields": [ ... ]
}
```

| Property | Meaning |
|---|---|
| `key` | Unique field key (`field_hero_slides`). Never change after data exists — ACF stores data *keyed by the field key*. |
| `label` | Editor-facing label ("Slides"). |
| `name` | **The machine name** used in PHP: `get_field('slides')`. |
| `type` | `repeater` — an ACF Pro field type that lets the user add **multiple rows** of sub-fields. This is what powers the multi-slide carousel. |
| `layout` | `block` — each row is stacked as a block (vs. `table`/`row` layouts). |
| `min` / `max` | Minimum 1 and maximum 10 slides. |
| `button_label` | Text of the "Add Slide" button. |
| `sub_fields` | The fields each slide row contains (see below). |

### 7c. The sub-fields (one per slide)

Each slide is itself a mini data object. Let's look at each sub-field:

**Background Image** (image field, `return_format: "id"`):
```json
{
    "key": "field_hero_slide_background",
    "label": "Background Image",
    "name": "background_image",
    "type": "image",
    "required": 1,
    "return_format": "id",
    "preview_size": "medium",
    "parent_repeater": "field_hero_slides"
}
```
- Type `image` shows the media library picker.
- **`return_format: "id"` is critical**: ACF returns the *attachment ID* instead of a URL/array. The template then uses `wp_get_attachment_image($id, ...)` to output a responsive, `srcset`-aware `<img>`. Returning the ID is best practice.
- `required: 1` — you must pick an image.
- `parent_repeater` — links this sub-field back to its parent repeater (ACF bookkeeping).

**Eyebrow** (text):
```json
{
    "key": "field_hero_slide_eyebrow",
    "label": "Eyebrow",
    "name": "eyebrow",
    "type": "text",
    "instructions": "Small label above the headline (e.g. 'The Brotherhood').",
    "required": 0
}
```
- A plain single-line text input. `required: 0` = optional.

**Title** (text, required):
- The main headline line 1. `required: 1` — every slide must have a title.

**Line 2 (accent)** (text, optional):
- A second headline line that the CSS renders in the accent colour. Optional.

**Description** (textarea):
```json
{
    "key": "field_hero_slide_description",
    "name": "description",
    "type": "textarea",
    "rows": 3,
    "new_lines": ""
}
```
- A multi-line paragraph input, 3 rows tall. `new_lines: ""` = store line breaks as-is.

**Button Text** (text, optional):
- The CTA button label. If empty, no button is shown.

**Button URL** (url):
```json
{
    "key": "field_hero_slide_button_url",
    "name": "button_url",
    "type": "url",
    "conditional_logic": [
        {
            "field": "field_hero_slide_button_text",
            "operator": "!=empty"
        }
    ]
}
```
- A URL input. **`conditional_logic`** is the interesting part: the field *only appears* when **Button Text is not empty** (`!=empty`). This keeps the UI clean — you only set a URL if you've written a button label.

### 7d. The `Content Layout` field

```json
{
    "key": "field_hero_layout",
    "label": "Content Layout",
    "name": "layout",
    "type": "select",
    "required": 1,
    "choices": {
        "left": "Left Aligned",
        "center": "Center Aligned",
        "right": "Right Aligned"
    },
    "default_value": "left",
    "return_format": "value"
}
```
- A dropdown. Stores one of `left`, `center`, `right` (the `choices` keys).
- `return_format: "value"` means PHP gets the key (`'left'`), which the template uses directly as a CSS class (`hero-layout-left`).

> **Concept — field keys vs names**: ACF has two identifiers. **Key** (`field_hero_slide_title`) = the permanent, internal ID used for storage and conditional logic. **Name** (`title`) = the human/machine-friendly slug you use in `get_field()`. Edit *names* freely; never change *keys* of fields that already have data.

---

## 8. Step 5 — Local JSON save/load: `inc/acf-json.php`

```php
<?php
/**
 * ACF local JSON configuration.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_acf_json_save_point' ) ) {
	function custom_theme_acf_json_save_point( string $path ): string {
		return get_template_directory() . '/acf-json';
	}
}
add_filter( 'acf/settings/save_json', 'custom_theme_acf_json_save_point' );

if ( ! function_exists( 'custom_theme_acf_json_load_point' ) ) {
	function custom_theme_acf_json_load_point( array $paths ): array {
		$paths[] = get_template_directory() . '/acf-json';
		return $paths;
	}
}
add_filter( 'acf/settings/load_json', 'custom_theme_acf_json_load_point' );
```

### What each part does

ACF's "local JSON" feature lets field groups live as `.json` files in the theme instead of only in the database. This makes field groups **version-controlled** (git) and **deployable** across environments.

- **`acf/settings/save_json` filter** — returns the *folder path* where ACF writes the JSON whenever a field group is saved in wp-admin. The theme redirects it to `get_template_directory() . '/acf-json'`.
- **`acf/settings/load_json` filter** — returns an *array of paths* ACF reads field groups from. Note it **appends** to the incoming `$paths` array rather than replacing it, so the theme's JSON is loaded in addition to any plugin's.
- Together: edit fields in the admin → ACF saves `group_hero.json` to the theme → the file is committed to git → other environments/deployments load the same field groups automatically.

> **Concept — the sync step**: When the JSON file on disk is newer than the DB version, wp-admin shows **Custom Fields → Sync** with a "Sync" button. Clicking it imports the file's field group into the DB. That's why the block README says: *"Go to Custom Fields → Sync and sync the Hero group."*

---

## 9. Step 6 — The render template: `blocks/hero/render.php`

This is the heart of the block — the PHP that turns saved ACF data into the final HTML.

### 9a. Fetching the data

```php
<?php
$slides = get_field( 'slides' );
$layout = get_field( 'layout' ) ?: 'left';

if ( empty( $slides ) ) {
    return;
}
```

- **`get_field('slides')`** — ACF's core data-reader. Inside a block's render template, it returns the block's own field values (no post ID needed — ACF knows the context). For a repeater it returns an **array of rows**, each row being an associative array of sub-field values keyed by their *names*: `$slide['background_image']`, `$slide['title']`, etc.
- **`get_field('layout') ?: 'left'`** — reads the layout dropdown; the `?:` (null coalescing via ternary) gives a fallback of `'left'` if the field is empty. This is the classic "safe default" pattern.
- **`if (empty($slides)) return;`** — an important guard. If the block was added but no slides exist yet (or the block is being rendered in a context with no data), output **nothing** rather than broken markup. In Gutenberg block rendering, `return` (void) tells WordPress the block is empty.

### 9b. Building wrapper attributes

```php
$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'hero-block hero-layout-' . esc_attr( $layout ),
) );
```

- **`get_block_wrapper_attributes()`** — a WordPress function available inside block render templates. It returns a string of HTML attributes (`class="wp-block-wp-theme-hero ..."`, plus alignment classes and any anchor) built from the `supports` settings in `block.json`.
  - The block's base class is always `wp-block-wp-theme-hero` (derived from the block `name`).
  - Passing `array('class' => '...')` **merges** extra classes in.
  - Because the *editor* can set background/color/spacing via `supports`, this function injects those CSS custom properties automatically — the block "just works" with the editor controls.
- **`'hero-layout-' . esc_attr($layout)`** — builds `hero-layout-left` / `hero-layout-center` / `hero-layout-right`, which the CSS uses to reposition content. `esc_attr()` sanitizes the value for safe use inside an HTML attribute.

### 9c. The outer markup

```html
<div <?php echo $wrapper_attributes; ?>>
    <div class="hero-slider" data-hero-slider>
        <?php foreach ( $slides as $i => $slide ) : ?>
```

- The outer `<div>` is the **block root** — WordPress/ACF give it the wrapper attributes so alignment, anchor, and editor colors work.
- `<div class="hero-slider" data-hero-slider>` — the slider *container*. The `data-hero-slider` attribute is a **JavaScript hook**: `hero-slider.js` queries `document.querySelectorAll('[data-hero-slider]')` and attaches the slider behaviour there. Using `data-*` attributes instead of classes for JS hooks keeps CSS and JS concerns separate.
- `foreach ( $slides as $i => $slide )` — loop over the repeater rows. `$i` is the zero-based index (used to mark the first slide active). `$slide` is one row's array of values.

### 9d. One slide

```html
<div data-hero-slide class="hero-slide <?php echo 0 === $i ? 'is-active' : ''; ?>">
    <?php
    $image_id = $slide['background_image'];
    if ( $image_id ) :
        echo wp_get_attachment_image( $image_id, 'full', '', array(
            'class'   => 'hero-slide-image',
            'decoding' => 'async',
            ( 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"' ),
        ) );
    endif;
    ?>
    <div class="hero-overlay"></div>
```

- **`data-hero-slide`** — JS hook for each slide. **`is-active`** class marks the currently visible slide (first slide starts active). Note `0 === $i` (strict comparison, variable on the right — a common PHP style choice).
- **`$slide['background_image']`** — remember `return_format: "id"`, so this is an attachment **ID**.
- **`wp_get_attachment_image($id, 'full', '', ['class' => ..., 'decoding' => ..., ...])`** — WP core function that outputs a proper `<img>` tag with `srcset`, `sizes`, and dimensions. `'full'` is the largest registered image size. The attributes array:
  - `'class' => 'hero-slide-image'` — styling hook.
  - `'decoding' => 'async'` — performance hint: let the browser decode the image off the critical path.
  - The third array item is a **small trick**: for the *first* slide it outputs `fetchpriority="high"` (LCP optimization — the hero image above the fold should load ASAP), and for all other slides `loading="lazy"` (defer off-screen images). Since they're mutually exclusive, this array item is a compact conditional attribute.
- **`<div class="hero-overlay"></div>`** — a purely decorative div that the CSS uses to draw a dark gradient over the image so white text stays readable.

### 9e. Slide content

```html
<div class="hero-slide-content">
    <?php if ( ! empty( $slide['eyebrow'] ) ) : ?>
        <div class="hero-eyebrow"><span><?php echo esc_html( $slide['eyebrow'] ); ?></span></div>
    <?php endif; ?>

    <<?php echo is_admin() ? 'h2' : 'h1'; ?> class="hero-headline">
        <?php echo esc_html( $slide['title'] ); ?><br>
        <?php if ( ! empty( $slide['line_2'] ) ) : ?>
            <em class="hero-headline-accent"><?php echo esc_html( $slide['line_2'] ); ?></em>
        <?php endif; ?>
    </<?php echo is_admin() ? 'h2' : 'h1'; ?>>

    <?php if ( ! empty( $slide['description'] ) ) : ?>
        <p class="hero-description"><?php echo esc_html( $slide['description'] ); ?></p>
    <?php endif; ?>

    <?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_url'] ) ) : ?>
        <div class="hero-actions">
            <a class="hero-button" href="<?php echo esc_url( $slide['button_url'] ); ?>">
                <?php echo esc_html( $slide['button_text'] ); ?>
            </a>
        </div>
    <?php endif; ?>
</div>
```

Breaking it down:

- **Every piece of dynamic content is wrapped in `if (!empty(...))`** — optional fields only render when they have values. This keeps the HTML clean and avoids empty `<p>`/empty buttons. This is the standard ACF block pattern: *empty field → no element*.
- **`is_admin() ? 'h2' : 'h1'`** — the *smart heading* trick. In the **admin editor preview**, the page already has `h1` tags for the title, so the block renders `h2` to keep heading hierarchy valid; on the **frontend** it renders `h1` (the hero should be the page's main heading). Same logic opens and closes the tag.
- **`esc_html()`** — escapes all text output so raw HTML/JS in fields is neutralized (XSS prevention). **Always escape output** in WordPress templates. Text fields → `esc_html()`, URLs → `esc_url()`.
- **`<br>`** — the forced line break between title line 1 and line 2.
- **`<em class="hero-headline-accent">`** — the second line wrapped in `<em>`; CSS sets `font-style: normal` and recolors it, so the accent line is styled but still semantic emphasis.
- **The button** renders only if *both* `button_text` and `button_url` are set (matching the field group's conditional logic). `esc_url()` sanitizes the href.

### 9f. Navigation UI

```html
<button type="button" data-hero-prev class="hero-arrow hero-arrow-prev" aria-label="Previous slide">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
</button>
<button type="button" data-hero-next class="hero-arrow hero-arrow-next" aria-label="Next slide">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
</button>
<div class="hero-dots">
    <?php foreach ( $slides as $i => $slide ) : ?>
        <button type="button" data-hero-dot class="hero-dot <?php echo 0 === $i ? 'is-active' : ''; ?>" aria-label="Slide <?php echo (int) $i + 1; ?>"></button>
    <?php endforeach; ?>
</div>
<div data-hero-progress class="hero-progress">
    <div data-hero-progress-fill class="hero-progress-fill animate-slide-progress"></div>
</div>
```

- **Prev/Next arrows** — `data-hero-prev` / `data-hero-next` JS hooks. Inline SVGs (chevrons) keep the block dependency-free. `aria-label` gives screen readers meaningful names. `type="button"` prevents accidental form submission semantics.
- **Dots** — one `data-hero-dot` button per slide (index = DOM order, which `hero-slider.js` relies on). The first is `is-active`. `aria-label="Slide N"` uses `(int) $i + 1` so numbering starts at 1 for humans.
- **Progress bar** — `data-hero-progress` wraps `data-hero-progress-fill`, which carries the `animate-slide-progress` class that CSS animates (0% → 100% width) to show autoplay time remaining. The JS restarts/hides this animation.

> **Concept — progressive enhancement**: The markup is fully functional HTML (all slides stacked, arrows/dots present) even before any JS runs; the CSS hides inactive slides. `hero-slider.js` then *enhances* it with autoplay, swipe, and click behaviour. If JS fails, the first slide still shows.

---

## 10. Step 7 — Block styles: `blocks/hero/style.css`

This file is enqueued automatically by WordPress because of `"style": "file:./style.css"` in `block.json`. It's loaded on the frontend whenever the block is used, and in the editor so the preview matches. Let's go through the meaningful groups.

### 10a. Block root and slide layering

```css
.wp-block-wp-theme-hero {
    position: relative;
    overflow: hidden;
}

.hero-slider {
    position: relative;
    min-height: 90vh;
    min-height: 560px;
    overflow: hidden;
    background: #0a0a0a;
}

.hero-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    pointer-events: none;
    transition: opacity 1.1s ease;
}

.hero-slide.is-active {
    opacity: 1;
    pointer-events: auto;
}
```

- **`.wp-block-wp-theme-hero`** — the auto-generated class (block name `wp-theme/hero` → `wp-block-wp-theme-hero`). `position: relative` + `overflow: hidden` make it the positioning context for the absolutely-positioned slides and clip anything that overflows.
- **`.hero-slider`** — the stage. `min-height: 90vh` then `min-height: 560px` is a **CSS fallback pattern**: modern browsers accept `min-height: 90vh`; the second declaration (smaller, in px) only wins if the browser doesn't support `vh` units. Both are written intentionally as a progressive fallback. `background: #0a0a0a` is the loading colour behind the images.
- **`.hero-slide`** — `position: absolute; inset: 0` makes every slide overlap the stage exactly. `opacity: 0` hides all slides by default; the **`.is-active`** class fades one in with `transition: opacity 1.1s ease`. `pointer-events: none` (and `auto` on active) ensures hidden slides never intercept clicks. This is the fade cross-fade slider mechanism.

### 10b. Image and overlay

```css
.hero-slide-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(10,10,10,0.93) 35%, rgba(10,10,10,0.3) 75%, rgba(10,10,10,0.1) 100%);
}
```

- **`.hero-slide-image`** — stretches the `<img>` to fill the slide. `object-fit: cover` crops without distortion; `object-position: top` keeps the top of photos (faces/heads) visible on short screens.
- **`.hero-overlay`** — a left-to-right gradient: nearly opaque dark on the left (behind the text), fading to transparent on the right. This guarantees text contrast regardless of the photo.

### 10c. Content positioning + layout variants

```css
.hero-slide-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 clamp(24px, 5vw, 80px);
    padding-bottom: 5rem;
    z-index: 1;
    max-width: 620px;
}

.hero-layout-center .hero-slide-content {
    margin: 0 auto;
    text-align: center;
    align-items: center;
}

.hero-layout-right .hero-slide-content {
    margin-left: auto;
    text-align: right;
    align-items: flex-end;
}
```

- **`.hero-slide-content`** — fills the slide, uses flexbox to vertically center its children (`justify-content: center`). `max-width: 620px` keeps lines a readable length. `clamp(24px, 5vw, 80px)` = fluid horizontal padding (min 24px, preferred 5vw, max 80px).
- **`.hero-layout-center` / `.hero-layout-right`** — remember the `hero-layout-*` class added from the `layout` field. These rules reposition the content: `margin: 0 auto` + `text-align: center` centers it; `margin-left: auto` + `align-items: flex-end` pushes it right. **The `layout` ACF field directly controls these CSS classes** — a nice example of data → presentation mapping.

### 10d. Eyebrow (the accent rule line)

```css
.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

.hero-eyebrow::before,
.hero-eyebrow::after {
    content: '';
    height: 1px;
    max-width: 2.5rem;
    flex: 1;
    background: var(--wp--preset--color--accent, #22c55e);
}

.hero-layout-left .hero-eyebrow::after { display: none; }
.hero-layout-right .hero-eyebrow::before { display: none; }
```

- The eyebrow label is flanked by horizontal lines drawn with `::before` / `::after` pseudo-elements (no extra markup).
- **`var(--wp--preset--color--accent, #22c55e)`** — a fallback pattern: use the theme's `accent` design token (a `--wp--preset-*` CSS variable that WordPress core generates from theme.json) if defined, otherwise fall back to the hard-coded green `#22c55e`.
- For left/right layouts one of the two lines is hidden so the line only extends *behind* the text (not outside the edge).

### 10e. Headline, description, button

```css
.hero-headline {
    font-size: clamp(3.2rem, 7.5vw, 6.5rem);
    font-weight: 700;
    line-height: 0.92;
    letter-spacing: 2px;
    color: #fff;
    margin: 0 0 1.25rem;
    font-family: var(--wp--preset--font-family--display, inherit);
}
```
- Fluid type with `clamp()` (min 3.2rem, scales with viewport, max 6.5rem). Uses the `display` font family token (Bebas Neue) if available.

```css
.hero-description {
    font-size: 1rem;
    line-height: 1.8;
    color: rgba(255,255,255,0.55);
    max-width: 440px;
    margin: 0 0 2rem;
}
```
- Muted white text (`0.55` opacity), readable line-height, capped width.

```css
.hero-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.9375rem 2.375rem;
    border-radius: 9999px;
    background: var(--wp--preset--color--accent, #22c55e);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    transition: all 0.25s;
    cursor: pointer;
    border: 0;
}

.hero-button:hover {
    filter: brightness(1.1);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(58,125,68,0.3);
}
```
- The pill-shaped CTA. `border-radius: 9999px` makes the fully-rounded pill. Hover lifts it (`translateY(-2px)`) and adds a green glow.

### 10f. Arrows, dots, progress bar

```css
.hero-arrow {
    position: absolute;
    top: 50%;
    z-index: 4;
    transform: translateY(-50%);
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(10,10,10,0.55);
    color: #fff;
    cursor: pointer;
    backdrop-filter: blur(8px);
}
.hero-arrow-prev { left: clamp(12px, 3vw, 32px); }
.hero-arrow-next { right: clamp(12px, 3vw, 32px); }
```
- Round, glassy (semi-transparent + `backdrop-filter: blur`) buttons vertically centered on the sides with fluid offsets.

```css
.hero-dots {
    position: absolute;
    inset-inline: 0;
    bottom: 2.25rem;
    z-index: 4;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}
.hero-dot {
    width: 7px;
    height: 7px;
    border-radius: 4px;
    background: rgba(255,255,255,0.2);
    transition: all 0.35s;
}
.hero-dot.is-active {
    width: 1.5rem;
    background: var(--wp--preset--color--accent, #22c55e);
}
```
- Inactive dots are small grey pills; the active dot animates wider (`1.5rem`) and turns accent-green — a classic carousel indicator.

```css
.hero-progress {
    position: absolute;
    inset-inline: 0;
    bottom: 0;
    z-index: 4;
    height: 3px;
    background: rgba(255,255,255,0.07);
}
.hero-progress-fill {
    height: 100%;
    width: 0;
    background: var(--wp--preset--color--accent, #22c55e);
}
```
- A 3px track at the bottom edge; the fill starts at `width: 0` and the `animate-slide-progress` animation (defined globally, see Step 9) grows it to 100%.

---

## 11. Step 8 — Slider behaviour: `assets/js/hero-slider.js`

```js
/**
 * Hero slider — WordPress replacement for the React Hero component's state.
 *
 * Hooks:
 *   [data-hero-slider]        root <section>, optional data-hero-interval (ms, default 6000)
 *   [data-hero-slide]         slide wrapper; active slide gets `.is-active`
 *   [data-hero-prev]/[data-hero-next]  arrow buttons
 *   [data-hero-dot]           dot buttons (index = DOM order); active gets `.is-active`
 *   [data-hero-progress]      progress wrapper (hidden while paused)
 *   [data-hero-progress-fill] fill bar, animated via `animate-slide-progress`
 */
```

The file is wrapped in an **IIFE** (Immediately Invoked Function Expression) with `'use strict'`:
```js
(function () {
	'use strict';
	document.querySelectorAll('[data-hero-slider]').forEach(function (root) {
		...
	});
})();
```
- The IIFE keeps all variables out of the global scope (no pollution).
- `querySelectorAll('[data-hero-slider]').forEach(...)` — finds **every** hero block on the page (in case several posts/blocks use it) and initializes each independently. This is why the block is reusable.

### 11a. Wiring up the DOM nodes

```js
var slides = Array.prototype.slice.call(root.querySelectorAll('[data-hero-slide]'));
var dots = Array.prototype.slice.call(root.querySelectorAll('[data-hero-dot]'));
var prev = root.querySelector('[data-hero-prev]');
var next = root.querySelector('[data-hero-next]');
var progress = root.querySelector('[data-hero-progress]');
var fill = progress ? progress.querySelector('[data-hero-progress-fill]') : null;

if (!slides.length) {
    return;
}

var interval = parseInt(root.getAttribute('data-hero-interval'), 10) || 6000;
var active = 0;
var timer = null;
var touchStartX = 0;
```

- `querySelectorAll` returns a static `NodeList`; `Array.prototype.slice.call(...)` converts it to a real array so `.forEach` and indexing behave predictably.
- `progress ? progress.querySelector(...) : null` — guard against a missing progress element.
- `if (!slides.length) return;` — bail if no slides (safety).
- `data-hero-interval` — the render template doesn't output this attribute, so it defaults to **6000 ms**. It's read here so the interval could be customized per-block without code changes (progressive config via data attribute).
- **State**: `active` (current index), `timer` (autoplay handle), `touchStartX` (swipe origin).

### 11b. Progress bar restart

```js
function restartProgress() {
    if (!fill) {
        return;
    }
    fill.classList.remove('animate-slide-progress');
    void fill.offsetWidth; // force reflow so the animation restarts at 0
    fill.classList.add('animate-slide-progress');
}
```

- To restart a CSS animation you must remove its class, force a reflow, and re-add it. Reading `fill.offsetWidth` synchronously forces the browser to recompute layout, guaranteeing the animation genuinely restarts from 0% (otherwise the browser may skip the restart).

### 11c. Render — apply state to the DOM

```js
function render() {
    slides.forEach(function (slide, i) {
        slide.classList.toggle('is-active', i === active);
    });
    dots.forEach(function (dot, i) {
        dot.classList.toggle('is-active', i === active);
    });
    restartProgress();
}
```

- `classList.toggle('is-active', condition)` — adds `is-active` where the condition is true, removes it elsewhere. One pass updates both slides and dots. CSS transitions do the visual work.

### 11d. Navigation math

```js
function goTo(i) {
    active = ((i % slides.length) + slides.length) % slides.length;
    render();
}
```

- This is the **modulo wrap-around** trick: `((i % n) + n) % n` always yields a valid index in `0..n-1` even for negative inputs. So `goTo(-1)` (previous from slide 0) wraps to the last slide — infinite looping with no branching.

### 11e. Autoplay with hover-pause

```js
function start() {
    stop();
    timer = window.setInterval(function () {
        goTo(active + 1);
    }, interval);
    if (progress) {
        progress.classList.remove('hidden');
    }
    restartProgress();
}

function stop() {
    if (timer) {
        window.clearInterval(timer);
        timer = null;
    }
    if (progress) {
        progress.classList.add('hidden');
    }
}

root.addEventListener('mouseenter', stop);
root.addEventListener('mouseleave', start);
```

- `setInterval` advances one slide every `interval` ms. `stop()` clears the timer and hides the progress bar (class `hidden` — note the CSS here relies on a global `.hidden { display: none }` utility from Tailwind); `start()` re-arms it and restarts the fill animation fresh (mirroring the old React component's behaviour of re-mounting the progress bar).

### 11f. Controls

```js
if (prev) {
    prev.addEventListener('click', function () {
        goTo(active - 1);
    });
}
if (next) {
    next.addEventListener('click', function () {
        goTo(active + 1);
    });
}

dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
        goTo(i);
    });
});
```

- Arrows step ±1; each dot jumps to its own index. The `if (prev)` guards handle optional markup.

### 11g. Touch swipe

```js
root.addEventListener('touchstart', function (event) {
    touchStartX = event.touches[0].clientX;
}, { passive: true });

root.addEventListener('touchend', function (event) {
    var delta = touchStartX - event.changedTouches[0].clientX;
    if (Math.abs(delta) > 40) {
        goTo(active + (delta > 0 ? 1 : -1));
    }
}, { passive: true });
```

- Records the horizontal touch origin; on release computes the delta. Only if the swipe exceeds the **40px threshold** does it advance (swipe left → next, swipe right → previous). `{ passive: true }` tells the browser the handler won't call `preventDefault()`, so scrolling isn't blocked — a performance/UX requirement.

### 11h. Boot

```js
render();
start();
```

- Finally, each slider is drawn at its initial state and autoplay begins.

> **Concept — separation of concerns**: The HTML (`render.php`) has zero inline JS logic; it just exposes `data-hero-*` hooks. The JS finds hooks and wires behaviour. This keeps the block fully server-rendered (SEO/SSR friendly) and progressively enhanced.

---

## 12. Step 9 — Global CSS tokens: `src/input.css`

The `animate-slide-progress` class used in the render template is *not* defined in `style.css` — it's a Tailwind v4 token defined globally:

```css
@theme {
  --color-ink: #0A0A0A;
  --color-green: #3A7D44;
  --color-accent: #3A7D44;
  --font-display: "Bebas Neue", sans-serif;

  /* Hero autoplay progress bar */
  --animate-slide-progress: slide-progress 6000ms linear forwards;
  @keyframes slide-progress {
    from { width: 0%; }
    to   { width: 100%; }
  }
}
```

- Tailwind v4's `@theme` block declares design tokens. Declaring `--animate-slide-progress` there creates the `.animate-slide-progress` utility class automatically (compiled into `assets/css/tailwind.css`).
- The **`@keyframes slide-progress`** animates width `0% → 100%` over **6000 ms**, linear, `forwards` (stays at 100%). The `6000ms` matches the JS default autoplay interval exactly, so the fill bar finishes precisely when the next slide auto-advances.
- The compiled CSS adds the utility:
  ```css
  .animate-slide-progress {
      animation: var(--animate-slide-progress);
  }
  ```
- This is why the block README lists Tailwind as an optional dependency — if you removed Tailwind, you'd need to define this animation yourself.

> **Concept — where CSS lives**: Block-specific styles live in the block's own `style.css` (enqueued only when the block is used — good for performance). Cross-cutting/global utilities live in the compiled Tailwind build. Both are needed to render the hero correctly.

---

## 13. Step 10 — Enqueueing scripts: `inc/theme-js.php`

```php
function custom_theme_enqueue_js(): void {
    $version = wp_get_theme()->get( 'Version' );

    // Hero slider — autoplay, hover-pause, swipe, arrows, dots, progress.
    wp_enqueue_script( 'iga-hero-slider', get_theme_file_uri( 'assets/js/hero-slider.js' ), [], $version, true );
    // ... other scripts (modal, reveal, pricing-tabs)
}
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_js' );
```

- **`wp_enqueue_script(handle, src, deps, version, in_footer)`** — the WordPress-correct way to load JS:
  - `'iga-hero-slider'` — unique handle.
  - `get_theme_file_uri('assets/js/hero-slider.js')` — public URL to the file.
  - `[]` — no dependencies.
  - `$version` — theme version, used as a cache-busting query string (`?ver=1.0.1`).
  - `true` — load in the **footer** (better performance; the DOM it queries already exists).
- Hooked to `wp_enqueue_scripts`, which fires on every frontend page load. The script is small and uses `querySelectorAll`, so it's fine to load site-wide; the `.hidden` class it toggles is provided by the Tailwind global CSS.

> **Contrast**: the block's *CSS* is enqueued automatically via `block.json` → `"style"`, but the slider's *JS* is enqueued manually here because `block.json` doesn't have a built-in per-block JS mechanism without a plugin or `viewScript` in modern WP — a theme-level enqueue is the simplest reliable approach.

---

## 14. The full data flow from editor to browser

Putting it all together, here's the complete journey of the Hero block:

1. **Theme loads** — `functions.php` requires all `inc/` modules.
2. **Dependency check** — `acf-requirements.php` confirms ACF Pro is active, else dies/notices.
3. **Block registration** — on `acf/init`, `acf-blocks.php` globs `blocks/*/block.json` and calls `register_block_type()` for each → the Hero block appears in the Gutenberg inserter under *Design*.
4. **Field group loading** — ACF reads `acf-json/group_hero.json` (via the `load_json` filter). Because the `location` rule matches block `wp-theme/hero`, the form is attached to the block.
5. **Editor fills data** — user adds the Hero block, clicks "Add Slide", uploads a background image, types title/eyebrow/description/button, picks a layout. Conditional logic hides "Button URL" until "Button Text" is filled.
6. **Save** — WordPress serializes the block (with its ACF data) into the post's `post_content`.
7. **Frontend render** — when a visitor loads the page, WordPress finds the block, runs `blocks/hero/render.php`. Inside, `get_field('slides')` and `get_field('layout')` read the saved values; the template outputs the wrapper (via `get_block_wrapper_attributes()`), the slides, arrows, dots, and progress bar.
8. **CSS** — `style.css` (auto-enqueued by `block.json`) styles the block; the accent/display tokens come from the theme's compiled Tailwind CSS; the progress animation from `animate-slide-progress`.
9. **JS** — `hero-slider.js` (enqueued in footer by `theme-js.php`) finds `[data-hero-slider]`, attaches autoplay/hover-pause/swipe/arrows/dots, and manages the `is-active` classes that trigger the CSS fades.

---

## 15. How to create your own block (the pattern)

Following this theme's conventions, a new block is just three files:

```
blocks/my-block/
├── block.json      ← name, title, supports, "acf": { "renderTemplate": "render.php" }
├── render.php      ← get_field(...) → HTML
└── style.css       ← optional per-block styles
```

Steps:

1. Create `blocks/my-block/block.json` with a unique `name` like `wp-theme/my-block`.
2. Create `render.php`; read data with `get_field()` and echo escaped HTML, guarding optional fields with `if (!empty(...))`.
3. (Optional) create the field group in wp-admin (or write `acf-json/group_my-block.json`) with a `location` rule: `param = block`, `value = wp-theme/my-block`.
4. (Optional) add `style.css` and reference it via `"style": "file:./style.css"`.
5. Nothing else — `acf-blocks.php` auto-registers it. Sync field JSON in **Custom Fields → Sync**.
6. Add any behaviour JS to `assets/js/` and enqueue it in `theme-js.php` (hook off the block markup with `data-*` attributes).

---

## 16. Key takeaways / glossary

| Term | Meaning |
|---|---|
| **ACF block** | A custom Gutenberg block whose content is ACF fields and whose output is a PHP template. |
| **block.json** | Declarative metadata: name, icon, supports, and the ACF render template. |
| **register_block_type()** | WP function that makes a block available in the editor; reading from a folder path uses its `block.json`. |
| **acf/init** | The ACF hook on which block types *must* be registered. |
| **Field group** | A set of ACF fields, attached to the block via a `location` rule (`param: block`). |
| **Repeater** | ACF Pro field type for repeatable rows of sub-fields (drives the slides). |
| **Field key vs field name** | Key = permanent storage ID; name = the slug used in `get_field('name')`. |
| **get_field()** | ACF's data reader; inside a block template it returns that block's values. |
| **get_block_wrapper_attributes()** | Generates the block root's class/anchor/align attributes, merging `supports` settings. |
| **acf-json / Local JSON** | Field groups versioned as JSON in the theme via `save_json`/`load_json` filters. |
| **data-* attributes** | JS hooks that decouple behaviour (hero-slider.js) from markup. |
| **Escaping** | `esc_html()` / `esc_url()` — sanitizing output to prevent XSS. |
| **Progressive enhancement** | The block works (first slide visible) without JS; JS adds slider behaviour. |
| **`is_active` / modulo wrap** | How the slider tracks the visible slide and loops infinitely. |

### The mental model

> **Think of an ACF block as a function: `block.json` declares the input schema, ACF fields hold the input values, and `render.php` is the output. `style.css` and `hero-slider.js` are the presentation and behaviour layers that make that output look and act like a real component.**
