# Problems → Solutions

Best-match product for each of the 6 "Shop by Concern" tiles in `Pasted image (2).png`, picked from the full 34-product catalog in `cilla-sykn-products-exported-wc-product-export-with-prices-14-9-2026-1789373342585.csv` (matched primarily on each product's own "Suitable For" tags and description copy).

| # | Concern (image) | Subtitle (image) | Best-match product | Category | Price |
|---|---|---|---|---|---|
| 1 | Dryness & Dehydration | Replenish. Restore. Rebalance. | **Ceramide Cocoon Barrier Repair Body Lotion 500ml** | Body Lotions | R599 |
| 2 | Uneven Tone | A more even, radiant you. | **Kalahari Nectar Even Tone Hydrating Body Lotion 500ml** | Body Lotions | R479 |
| 3 | Sensitive Barrier Care | Kind care. Lasting strength. | **Oat Therapy Soothing Lipid Body Oil 100ml** | Body Oils | R489 |
| 4 | Oily & Acne-Prone Skin | Balance excess oil, refine the look of pores, and support clearer, healthier-looking skin. | **Clarity Reset Clarifying Serum 30ml** | Serums & Treatments | R349 |
| 5 | Blemishes & Breakouts | For skin prone to occasional blemishes, spots and breakouts. | **Smooth Operator Salicylic Body Wash 500ml** | Body Cleansers | R449 |
| 6 | Fine Lines & Loss of Firmness | For skin showing visible signs of texture, fine lines or changing firmness. | **Silhouette Therapy Firming Body Lotion 300ml** | Body Lotions | R429 |

---

## Reasoning per tile

### 1. Dryness & Dehydration → Ceramide Cocoon Barrier Repair Body Lotion 500ml
`Suitable For: Dry • Very Dry • Sensitive • Eczema-Prone Skin`. Dryness is its lead tag, and its own copy — "deeply hydrating **daily** body lotion... helps **replenish** moisture" — echoes "Replenish. Restore. Rebalance." almost word for word. The photography for this tile is a body/shoulder shot, matching a body lotion over a face product.

### 2. Uneven Tone → Kalahari Nectar Even Tone Hydrating Body Lotion 500ml
No contest — the product is literally named "**Even Tone**". `Suitable For: Dry • Dull • Uneven-Looking • Dark-Mark-Prone Body Skin`, and its copy promises a "more luminous-looking finish," matching "A more even, radiant you."
- *Runner-up*: Golden Hour Brightening Serum-Emulsion (face) targets the same dullness/uneven-tone/dark-mark concern, but is a face serum, not a match for this tile's body-skin photo.

### 3. Sensitive Barrier Care → Oat Therapy Soothing Lipid Body Oil 100ml
`Suitable For: Dry • Very Dry • Sensitive • Eczema-Prone Skin` — same skin profile as Ceramide Cocoon (tile 1), and its own copy is explicitly framed around barrier care: "designed to layer beautifully over Ceramide Cocoon Body Lotion as the final nourishing step in a **barrier-focused body routine**." Fragrance-free, which fits "Kind care."
- *Close alternative*: Urea Comfort Hydrating Shower Gel — also fragrance-free/soap-free and sensitive/eczema-prone-suitable, and pairs as the cleansing step of the same barrier routine (Urea Comfort → Ceramide Cocoon → Oat Therapy is the brand's own suggested 3-step routine per the product copy).

### 4. Oily & Acne-Prone Skin → Clarity Reset Clarifying Serum 30ml
`Suitable For: Oily • Combination • Blemish-Prone • Congested • Uneven-Looking Skin`. This is the most concentrated active treatment in the whole "Clarity Reset" line (Salicylic Acid, Azelaic Acid, Niacinamide, Zinc PCA, Bakuchiol, Ectoin), and its own copy — "supports a clearer, more **balanced**-looking complexion" — maps directly onto "**Balance** excess oil, refine the look of pores, and support **clearer, healthier**-looking skin."

### 5. Blemishes & Breakouts → Smooth Operator Salicylic Body Wash 500ml
`Suitable For: Oily • Blemish-Prone • Congested • Rough or Textured Body Skin`. Its copy is a near-verbatim match: "a targeted **daily body cleanser** created for areas prone to congestion, excess oil, rough texture and **body blemishes**." Kept distinct from tile 4's pick so the two aren't the same SKU, and its body-wash format/body photography fits this tile's shoulder shot better than another face product from the same Clarity Reset line.
- *Close alternative*: Clarity Reset Clarifying Face + Body Mask 250ml — also tagged Blemish-Prone/Congested and usable on face **or** body, but positioned as a 1–2×/week targeted treatment rather than the everyday "prone to breakouts" cleanser the subtitle implies.

### 6. Fine Lines & Loss of Firmness → Silhouette Therapy Firming Body Lotion 300ml
`Suitable For: Loss of Firmness • Stretch-Mark-Prone • Uneven Texture • Dry Body Skin` — "Loss of Firmness" is an exact tag match for this tile's title, and "Uneven Texture" covers the "visible signs of texture" half of the subtitle.
- *Close alternative*: H-P-E Triad Advanced Night Renewal Serum (face) is tagged `Early Signs of Ageing`, the closest catalog match to "fine lines" specifically — but it's a face serum, while this tile (like the other 5) is photographed on body skin, so the body-firming lotion is the better fit here.

---

## Notes

- All 6 picks are distinct products (no SKU repeated across tiles), spanning 4 categories: Body Lotions (3), Body Oils (1), Serums & Treatments (1), Body Cleansers (1).
- Matching was done using each product's own `Suitable For` tag line and short/long description text from the CSV's `Description` column — not by guessing from the product name alone.
- Prices are the `Regular price` values currently in the CSV (added from `Cilla_Skyn_Website_Product_Descriptions_No_Trademark_with_prices.xlsx` in a prior update).
