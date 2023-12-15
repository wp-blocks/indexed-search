# Schema

The database base structure used to index WordPress documents for search.

## Document

Has many words through the `document_word` table.

Has many meta words through the `document_meta` table.

Has many hits through the `query_hit` table.

The biggest documents to index will be posts.

There will need to be a way to indicated document type.

|id|index_id|
|--|--------|

## Index

Used to group indexed documents and track queries.

Has many documents.

|id|name|description|type|
|--|----|-----------|----|

## DocumentWord

Ranking the importance of a word in the document based on meta words could be done during the index process, if we know how to rank the words at the time of indexing.

|id|doc_id|word_id|position|
|--|------|-------|--------|

## DocumentMeta

Meta word table. `meta_id` is an enum of meta word types.

|id|doc_id|meta_id|position|
|--|------|-------|--------|

## Word

Has many documents through `document_word` table.

|id|value|
|--|-----|

## Gram

Unique segments of words.

Have many words through the `gram_word` table.

|id|value|length|
|--|-----|------|

## GramWord

Map partial word to full word

|id|word_id|gram_id|hit_count|
|--|-------|-------|---------|

## Query

User input queries.

|id|value|
|--|-----|

## Query Hit

Match successful queries to specific words contained in a document, independent of location with in the document. The concept is to have permanent link between query -> word -> document, used for ranking based on previous results.

|id|query_id|word_id|document_id|count|
|--|--------|-------|-----------|-----|
