<?php

namespace ArtisanUp\MorphUp\Generate\MorphMapping;

enum MorphMappingStrategy : string
{
    case CLASS_NAME = 'draft';
    case FULL_NAMESPACE = 'published';
}