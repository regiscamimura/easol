﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Learning Lab</title>


    <?php $this->carabiner->css('lib/bootstrap-3.3.6/dist/css/bootstrap.css'); ?>    
    <?php $this->carabiner->css('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css'); ?>
    
   <?php foreach ($GLOBALS['css'] as $file): ?>
        <?php $this->carabiner->css("$file"); ?>
   <?php endforeach; ?>

    <?php $this->carabiner->css('css/custom-styles2.css?v=2'); ?>


    <?php foreach ($GLOBALS['widget'] as $widget): ?>
        <?php if (!file_exists(FCPATH."/assets/widgets/$widget/{$widget}.css")) continue; ?>
        <?php $this->carabiner->css("widgets/$widget/{$widget}.css"); ?>
    <?php endforeach; ?>

    <?php if (file_exists(FCPATH."/assets/css/views/{$this->router->fetch_class()}.css")): ?>
        <?php $this->carabiner->css('css/views/'.$this->router->fetch_class().'.css'); ?>
    <?php endif; ?>

    <?php $this->carabiner->display('css'); ?>  
    
    <script type="text/javascript">
        var Easol_SiteUrl = "<?php echo site_url('/') ?>"
    </script>
</head>
<body>
  <div id="extension-wrapper" class="col-md-12 col-sm-12">
    <div id="extension-body" class="panel panel-default">
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline undo-overrides">
                  <div id="content-index-query" class="form-group">
                   
                    <input id="content-query" type="text" class="form-control input-sm" name="query" value="<?php echo (isset($_GET['query']) and !empty($_GET['query'])) ? $_GET['query'] : 'search text'; ?>">
                  </div>
                  <button type="submit" class="btn btn-default" id="content-search">Search</button>
                </form>
                <div class="pull-right">
                  <img src="<?php echo base_url().'/assets/img/learning_tapestry.png' ?>" border="0" />
                </div>
                <?php if (!empty($total_count)): ?>
                  <div>
                    Showing records <?php echo $start_count ?> to <?php echo $end_count ?> of <?php echo $total_count ?>
                  </div>
                <?php endif; ?>
                <?php if (isset($results)): ?>
                 <div class="left content-filters">
                    <?php foreach($filters_active as $k => $v) : ?>
                      <div class="checkbox">
                        <label class="tag tag-<?php echo strtolower($k) ?> button">
                          <input type="checkbox" class="filter_active" value="<?php echo $k ?>" checked><?php echo ucwords($v) ?>
                        </label>
                      </div>
                    <?php endforeach; ?>

                    <?php if (isset($filters->subjects)) { $filter = $filters->subjects;
$filtername = 'subjects'; ?>
                    <p><?php echo ucwords(preg_replace('/[^\da-z]/i', ' ', rtrim($filtername, 's'))); ?></p>
                    <?php foreach ($filter as $key => $val) : ?>
                      <a class="content-index-filterlink" href="<?php echo $filter_base_url . '&' . rtrim($filtername, 's') . '=' . urlencode($key); ?>"><?php echo ucwords($key) . ' (' . $val . ')'; ?></a>
                    <?php endforeach; 
                    } ?>

                    <?php if (isset($filters->publishers)) { $filter = $filters->publishers;
$filtername = 'publishers'; ?>
                    <p><?php echo ucwords(preg_replace('/[^\da-z]/i', ' ', rtrim($filtername, 's'))); ?></p>
                    <div id="publishers-list" class="filter-big-lists">
                        <form class="form-inline undo-overrides default-form-inline">
                            <div class="form-group">
                                <input class="search form-control input-sm" placeholder="Filter.."/>
                                <span class="sort" data-sort="filter-name"><i class="fa ea-sort-alpha"></i></span>
                                <span class="sort" data-sort="filter-count"><i class="fa ea-sort-numeric"></i></span>
                             </div>
                        </form>
                        <ul class="list list-unstyled">
                            <?php foreach ($filter as $key => $val) : ?>
                            <li>
                                <a class="content-index-filterlink" href="<?php echo $filter_base_url . '&' . rtrim($filtername, 's') . '=' . urlencode($key); ?>">
                                    <span class="filter-name"><?php echo ucwords($key) ?></span>
                                    <span class="filter-count">(<?php echo $val ?>)</span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php } ?>

                    <?php if (isset($filters->resource_types)) { $filter = $filters->resource_types;
$filtername = 'resource_types'; ?>
                    <p><?php echo ucwords(preg_replace('/[^\da-z]/i', ' ', rtrim($filtername, 's'))); ?></p>
                    <?php foreach ($filter as $key => $val) : ?>
                      <a class="content-index-filterlink" href="<?php echo $filter_base_url . '&' . rtrim($filtername, 's') . '=' . urlencode($key); ?>"><?php echo ucwords($key) . ' (' . $val . ')'; ?></a>
                    <?php endforeach; 
                    } ?>

                    <?php if (isset($filters->grades)) { $filter = $filters->grades;
$filtername = 'grades'; ?>
                    <p><?php echo ucwords(preg_replace('/[^\da-z]/i', ' ', rtrim($filtername, 's'))); ?></p>
                    <?php foreach ($filter as $key => $val) : ?>
                      <a class="content-index-filterlink" href="<?php echo $filter_base_url . '&' . rtrim($filtername, 's') . '=' . urlencode($key); ?>"><?php echo ucwords($key) . ' (' . $val . ')'; ?></a>
                    <?php endforeach; 
                    } ?>

                    <?php if (isset($filters->alignments)) { $filter = $filters->alignments;
$filtername = 'standards'; ?>
                    <p><?php echo ucwords(preg_replace('/[^\da-z]/i', ' ', rtrim($filtername, 's'))); ?></p>
                    <div id="standards-list" class="filter-big-lists">
                        <form class="form-inline undo-overrides default-form-inline">
                            <div class="form-group">
                                <input class="search form-control input-sm" placeholder="Filter.."/>
                                <span class="sort" data-sort="filter-name"><i class="fa ea-sort-alpha"></i></span>
                                <span class="sort" data-sort="filter-count"><i class="fa ea-sort-numeric"></i></span>
                             </div>
                        </form>
                        <ul class="list list-unstyled">
                            <?php foreach ($filter as $key => $val) : ?>
                            <li>
                                <a class="content-index-filterlink" href="<?php echo $filter_base_url . '&' . rtrim($filtername, 's') . '=' . urlencode($key); ?>">
                                   <span class="filter-name"><?php echo ucwords($key) ?></span>
                                   <span class="filter-count">(<?php echo $val ?>)</span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                         </ul>
                    </div>
                    <?php } ?>

                  </div>
                  <div class="left content-results">
                    <?php foreach ($results as $idx => $obj): ?>
                      <div class="clear">
                        <div class="left content-thumbnail">
                          <?php echo $obj->thumbnail; ?>
                        </div>                        
                        <div class="left content-desc" style="margin-left: 10px; padding-bottom: 40px">
                          <div class="content-title-publisher">
                            <h5 class="content-title"><a href="<?php echo $obj->resource_locators[0]->url; ?>" target="new"><?php echo $obj->title; ?></a></h5>
                            <div class="content-publisher"><?php if (isset($obj->identities)) { ?><a href="<?php echo $filter_base_url . '&publisher=' . urlencode($obj->identities[0]->name);?>"><?php echo $obj->identities[0]->name; ?></a><?php 
                           } ?></div>
                          </div>
                          <div class="well backtowell">
                            <?php echo $obj->description; ?>
                          </div>

                           <div class="btn-group btn-group-xs" role="group">
                            <?php foreach ($footnotes as $key => $value) : $p = key($value); ?>
                                <?php $idxLast = count($obj->$p) - 1; foreach ($obj->$p as $idxTag => $v): ?>
                                    <?php if ($idxTag == 6): ?>
                                        <a href="#collapsetag-<?php echo strtolower($key)?>-<?php echo $idx ?>" data-toggle="collapse" area-expanded="false" class="btn btn-info tag tag-<?php echo strtolower($key)?> collapsed tags-toggle" role="button">...</a>
                                        <span id="collapsetag-<?php echo strtolower($key)?>-<?php echo $idx ?>" class="collapse tags-collapsed">
                                    <?php endif; ?>
                                    <a href="<?php echo $filter_base_url . '&' . rtrim(strtolower($key), 's') . '=' . urlencode($v->$value[$p]);
?>" class="btn btn-info tag tag-<?php echo strtolower($key)?>" role="button"><?php echo $v->$value[$p]; ?></a>
                                    <?php if (($idxTag == $idxLast) && ($idxTag >= 6)) : ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                           </div>
                            <div class="right">
                            <div class="right content-links"><a href="<?php echo $obj->resource_locators[0]->url; ?>" class="extension" title="<?php echo $obj->title; ?>" description="<?php echo $obj->description; ?>">Add to Assignment</a></div>
                            <div class="right content-links"><a href="<?php echo $obj->resource_locators[0]->url; ?>" target="new">Preview</a></div>
                        </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                     <div class="clear">
                    <?php echo $this->pagination->create_links(); ?>
                     </div>
                     <br>
                  </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    </div>
  </div>
 

  <?php $this->carabiner->js('//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.js'); ?>
  <?php $this->carabiner->js('lib/bootstrap-3.3.6/dist/js/bootstrap.js'); ?>
  <?php $this->carabiner->js('lib/list.js'); ?>
  
  <?php $this->carabiner->js('js/custom.js') ?>

  <?php foreach ($GLOBALS['js'] as $file): ?>
    <?php if (!file_exists(FCPATH."/assets/$file")) continue; ?>
    <?php $this->carabiner->js("$file"); ?>
  <?php endforeach; ?>

  <?php foreach ($GLOBALS['widget'] as $widget): ?>
    <?php if (!file_exists(FCPATH."/assets/widgets/$widget/{$widget}.js")) continue; ?>
    <?php $this->carabiner->js("widgets/$widget/{$widget}.js"); ?>
  <?php endforeach; ?>

  <?php if (file_exists(FCPATH."/assets/js/views/{$this->router->fetch_class()}.js")): ?>
    <?php $this->carabiner->js("js/views/{$this->router->fetch_class()}.js"); ?>
  <?php endif; ?>

  <?php if (file_exists(FCPATH."/assets/js/views/{$this->router->fetch_class()}/{$this->router->fetch_method()}.js")): ?>
    <?php $this->carabiner->js("js/views/{$this->router->fetch_class()}/{$this->router->fetch_method()}.js"); ?>
  <?php endif; ?>

  <?php $this->carabiner->display('js'); ?>


</body>
</html>
