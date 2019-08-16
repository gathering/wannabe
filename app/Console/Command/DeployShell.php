<?php
class DeployShell extends AppShell {
    public function merge() {
        $this->out("Checking out productions and merging with development");
        system("sh ".ROOT.DS."scripts".DS."merge-production.sh ".ROOT.DS.APP_DIR.DS);
        $this->out("Done!");
    }
    public function push() {
        exec("sh ".ROOT.DS."scripts".DS."tag-production.sh ".ROOT.DS.APP_DIR.DS, $current_tag);
        $current_tag = $current_tag[0];
        $tag = null;
        if(isset($this->args[0])) {
            $tag = $this->args[0];
            if(str_replace('.','',$tag) < str_replace('.','',$current_tag))
                $this->error('Version parse failed. Too low.');
        } else {
            $tags = explode(".", $current_tag);
            $last = array_pop($tags);
            $last++;
            foreach($tags as $current) {
                $tag = $tag.$current.".";
            }
            $tag = $tag.$last;
        }
        $this->out('Pushing deploy to github with tag: '.$tag);
        system("sh ".ROOT.DS."scripts".DS."push-tag.sh ".ROOT.DS.APP_DIR.DS." ".$tag);
    }
    public function fetch() {
        $this->out("Fetching tags…");
        system("sh ".ROOT.DS."scripts".DS."fetch-tags.sh ".ROOT.DS.APP_DIR.DS);
        exec("sh ".ROOT.DS."scripts".DS."tag-production.sh ".ROOT.DS.APP_DIR.DS, $current_tag);
        $this->out("Checking out tag ".$current_tag[0]);
        system("sh ".ROOT.DS."scripts".DS."checkout-tag.sh ".ROOT.DS.APP_DIR.DS." ".$current_tag[0]);
    }
}
